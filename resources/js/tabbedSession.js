module.exports = (browserTabUrlParameter) => {
    // Parse query string
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    handleTabId(urlParams);
    window.tabId = sessionStorage.getItem(getTabQueryParameterName());

    function handleTabId(urlSearchParams) {
        if (urlSearchParams.has(getTabQueryParameterName('new'))) {
            // We have a new tabId, save it to the storage
            const newTabId = urlSearchParams.get(getTabQueryParameterName('new'));
            sessionStorage.setItem(getTabQueryParameterName(), newTabId);
            return newTabId;
        }

        const urlTabId = urlParams.get(getTabQueryParameterName());
        const storageTabId = sessionStorage.getItem(getTabQueryParameterName());

        if (urlTabId === null) {
            // Only the url tab id is missing, set it to have the correct referrer for livewire
            urlParams.set(getTabQueryParameterName(), storageTabId);
            location.search = urlParams.toString();
            return urlTabId;
        }

        if (storageTabId === null
            || storageTabId !== urlTabId) {
            // We have no tabId or something is wrong, request a new tabId
            if (urlParams.has(getTabQueryParameterName())) {
                urlParams.set(getTabQueryParameterName('old'), urlParams.get(getTabQueryParameterName()));
            }

            urlParams.delete(getTabQueryParameterName());
            location.search = urlParams.toString();
        }

        return null;
    }

    function getTabQueryParameterName(prefix = '') {
        const URL_PARAMETER_NAME = browserTabUrlParameter ?? 'tabId';

        if (prefix === '')
            return URL_PARAMETER_NAME;

        return prefix + URL_PARAMETER_NAME.charAt(0).toUpperCase() + URL_PARAMETER_NAME.slice(1);
    }
}
