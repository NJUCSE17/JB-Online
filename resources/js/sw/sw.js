/**
 * -------------------------------------
 * JB Polling Service Worker
 * -------------------------------------
 *
 * This script contains the main process
 * of the service worker that polls
 * notifications from the server and
 * then make notification to users.
 *
 * -------------------------------------
 *                (C) 2019 Tianyun Zhang
 */

import Dexie from 'dexie';

const sw_url = process.env.MIX_APP_URL + '/sw/poll';
const hm_url = process.env.MIX_APP_URL + '/home';

/**
 * Sleep for a period of time.
 * @param ms
 * @returns {Promise<any>}
 */
const sleep = (ms) => {
    return new Promise(resolve => {
        setTimeout(resolve, ms);
    });
};

/**
 * Main thread to poll notification.
 * @returns {Promise<void>}
 */
const sw_main = async () => {
    // read the token from indexedDB
    let db = new Dexie('sw_tokens');
    db.version(1).stores({tokens: '++id, name, token'});
    let query = await db.tokens.where('name').equals(process.env.MIX_APP_NAME).last();
    let sw_token = query.token;

    let fetch_options = {
        method: 'GET',
        mode: 'cors',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json;charset=UTF-8',
            'Authorization': 'Bearer ' + sw_token,
        },
    };
    while (true) {
        let response = await fetch(sw_url, fetch_options);
        if (!(response && response.ok)) throw response.status;

        let data = await response.json();
        if (data.length > 0) {
            for (let i = 0; i < data.length; ++i) {
                self.registration.showNotification(data[i].title, data[i].options);
            }
        }

        await sleep(60 * 1000);
    }
};

/**
 * Initialize the main thread.
 */
const sw_init = () => {
    sw_main().then(exitStatus => {
        sw_on_exit(exitStatus);
    }).catch(exitStatus => {
        sw_on_exit(exitStatus);
    });
};

/**
 * Error handler when exiting.
 */
const sw_on_exit = (exitStatus) => {
    registration.showNotification('推送服务已停止工作', {
        body: '退出状态：' + exitStatus + '；请访问'
            + process.env.MIX_APP_NAME + '主页来重新注册推送服务。',
        icon: '/favicon.png',
        url: '/home',
    });
};

/**
 * Service worker automatic updating handler.
 */
self.addEventListener('install', event => {
    skipWaiting();
});
self.addEventListener('activate', event => {
    clients.claim();
});

/**
 * SW notification click handler.
 */
self.onnotificationclick = event => {
    event.notification.close();
    event.waitUntil(clients.matchAll({
        type: "window"
    }).then(clientList => {
        for (var i = 0; i < clientList.length; i++) {
            var client = clientList[i];
            if (client.url === hm_url && 'focus' in client)
                return client.focus();
        }
        if (clients.openWindow)
            return clients.openWindow(hm_url);
    }));
};

sw_init();