/**
 * -------------------------------------
 * JB Polling Service Worker Register
 * -------------------------------------
 *
 * This script contains the process to
 * retrieve OAuth2.0 personal access
 * token and register the service worker
 * to the browser.
 *
 * -------------------------------------
 *                (C) 2019 Tianyun Zhang
 */

import Dexie from 'dexie';

/**
 * Retrieve a new access token from server.
 */
const retrieve_new_token = async () => {
    let sw_token = null;
    await window.axios.post('/sw/register', {
        // no data
    }).then(res => {
        sw_token = res.data;
    }).catch(err => {
        console.error(err);
    });
    return sw_token;
};

/**
 * The main procedure to retrieve the token
 * and register the service worker to browser.
 *
 * @returns {Promise<void>}
 */
const sw_register_main = async () => {
    let sw_token = JSON.parse(window.localStorage.getItem('sw_token'));
    if (!sw_token || window.Dayjs().isAfter(sw_token.token.expires_at)) {
        console.log('SW: Token not found or expired. Requesting a new one.');
        sw_token = await retrieve_new_token();
        if (!sw_token) {
            console.log('SW: Retrieve new SW token failed. Aborted.');
            return;
        } else {
            window.localStorage.setItem('sw_token', JSON.stringify(sw_token));
        }
    }

    // put the key into indexedDB for service worker to read
    const db = new Dexie('sw_tokens');
    db.version(1).stores({tokens: '++id, name, token',});
    let record = await db.tokens.where('name').equals(process.env.MIX_APP_NAME).last();
    if (!record || record.token !== sw_token.accessToken) {
        await db.tokens.add({
            name: process.env.MIX_APP_NAME,
            token: sw_token.accessToken,
        });
    }

    await navigator.serviceWorker.register(process.env.MIX_APP_URL + '/sw.js');
};

/**
 * Pre-checks before registering the service worker.
 *
 * @returns {Promise<void>}
 */
const sw_register = async () => {
    if (!('serviceWorker' in navigator)) {
        console.log('SW: Service worker is not supported in this browser.');
    } else if (!(window.indexedDB)) {
        console.log('SW: IndexedDB is not supported in this browser.');
    } else {
        if (Notification.permission !== 'denied' && Notification.permission !== 'granted') {
            console.log('SW: Notification is not granted. Request permission now.');
            await Notification.requestPermission();
        }
        if (Notification.permission === 'granted') {
            console.log('SW: Notification permission OK.');
            await sw_register_main();
            console.log('SW: Registration completed.');
        } else {
            console.log('SW: Notification is blocked.');
        }
    }
};

sw_register();