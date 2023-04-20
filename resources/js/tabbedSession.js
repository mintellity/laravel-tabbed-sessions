// Parse query string
const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
handleTabId(urlParams);

function handleTabId(urlSearchParams) {
    if (urlSearchParams.has('newTabId')) {
        // We have a new tabId, save it to the storage
        sessionStorage.setItem('tabId', urlSearchParams.get('newTabId'));
        return;
    }

    const urlTabId = urlParams.get('tabId');
    const storageTabId = sessionStorage.getItem('tabId');

    if (urlTabId === null) {
        // Only the url tab id is missing, set it to have the correct referrer for livewire
        urlParams.set('tabId', storageTabId);
        location.search = urlParams.toString();
        return;
    }

    if (storageTabId === null
        || storageTabId !== urlTabId) {
        // We have no tabId or something is wrong, request a new tabId
        if (urlParams.has('tabId')) {
            urlParams.set('oldTabId', urlParams.get('tabId'));
        }

        urlParams.delete('tabId');
        location.search = urlParams.toString();
    }
}
