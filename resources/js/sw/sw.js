/**
 * JB Polling Service Worker
 * (C) 2019 Tianyun Zhang
 */

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

const notification = async () => {
    while (true) {
        console.log("sleep.");
        await sleep(1000);
        console.log("wakeup!");
    }
    console.log("The SW main loop has exited.");
};

const ff = () => {

    registration.showNotification('Vibration Sample', {
        body: 'Buzz! Buzz!',
        icon: '/favicon.png',
        vibrate: [200, 100, 200, 100, 200, 100, 200],
        tag: 'vibration-sample'
    });
};

notification();