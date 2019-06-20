const sw_register = async () => {
    if (!('serviceWorker' in navigator)) {
        console.log('Service worker is not supported in this browser.');
    } else if (!('Notification' in window)) {
        console.log('Notification is not supported in this browser.');
    } else {
        console.log('Service worker runnable. Begin initialize process.');
        if (Notification.permission !== 'denied' && Notification.permission !== 'granted') {
            console.log('Notification is not granted. Request permission now.');
            await Notification.requestPermission();
        }
        if (Notification.permission === 'granted') {
            console.log('Notification permission OK. Begin sw registration.');
            navigator.serviceWorker.register('sw.js');
        } else {
            console.log('Notification is blocked.');
        }
    }
};

sw_register();