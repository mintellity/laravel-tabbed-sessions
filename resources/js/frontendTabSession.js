module.exports = (cookieName) => {
    window.tabSessionStorage = {
        set(key, value) {
            let currentValue = readSessionCookie();

            if (!currentValue)
                currentValue = {};

            if (!currentValue[window.tabId])
                currentValue[window.tabId] = {};

            currentValue[window.tabId][key] = value;
            writeSessionCookie(currentValue);
        },

        get(key) {
            const frontendSession = readSessionCookie();

            if (key && frontendSession[window.tabId])
                return frontendSession[window.tabId][key] ?? null;
            else
                return frontendSession[window.tabId] ?? null;
        }
    }

    function getCookieName() {
        return cookieName ?? 'frontend_tab_session';
    }

    function writeSessionCookie(value) {
        document.cookie = getCookieName() + "=" + encodeURIComponent(JSON.stringify(value)) + "; path=/";
    }

    function readSessionCookie() {
        const nameEQ = getCookieName() + "=";
        const ca = document.cookie.split(';');

        for (let i = 0; i < ca.length; i++) {
            let c = ca[i];

            while (c.charAt(0) === ' ')
                c = c.substring(1, c.length);

            if (c.indexOf(nameEQ) === 0)
                return JSON.parse(decodeURIComponent(c.substring(nameEQ.length, c.length))) ?? {};
        }

        return {};
    }
}
