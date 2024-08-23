After installing the package, you can use the frontend session to store the active tab and retrieve it on page reload.

Add this to your `app.js` file:

```js
document.addEventListener('show.bs.tab', function (e) {
    // Append the array of active tabs [URL => Tab]
    const activeTabs = window.tabSessionStorage.get('activeTab') ?? {};
    activeTabs[String(window.location.pathname)] = e.target.dataset.bsTarget;

    // Store the active tabs
    window.tabSessionStorage.set('activeTab', activeTabs);
});
```

And add this to either your `App\Providers\AppServiceProvider` or create a new provider e.g. `App\Providers\BladeServiceProvider`:

```php
public function boot()
{
    Blade::directive('tabActive', function (string $params) {
        $params = str_replace(' ', '', $params);
        $params = str_replace('\'', '', $params);
        $params = explode(',', $params);
    
        $tabId = $params[0];
        $defaultActive = ($params[1] ?? false) ? 'true' : 'false';
    
        return "<?php
            \$storedTab = browserTab()->frontendSession()->get('activeTab')['/' . request()->path()] ?? null;
    
            if (\$storedTab == null && $defaultActive) {
                echo 'active';
            } elseif (\$storedTab === \"$tabId\") {
                echo 'active';
            }
        ?>";
    });
}
```

To set the active tab, use the `tabActive` directive in your blade template:

```html
<ul class="nav nav-tabs tab-list" role="tablist">
    <li class="nav-item">
        <a class="nav-link @tabActive('#tabUser', true)" data-toggle="tab" role="tab" href="#tabUser" aria-controls="tabUser">
            Benutzer
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link @tabActive('#tabUserData')" data-toggle="tab" role="tab" href="#tabUserData" aria-controls="tabUserData">
            Benutzerdaten
        </a>
    </li>
</ul>

<div class="tab-content" id="customerTabContent">
    <div class="tab-pane @tabActive('#tabUser', true)" id="tabUser" role="tabpanel">
        ...
    </div>
    <div class="tab-pane @tabActive('#tabUserData')" id="tabUserData" role="tabpanel">
        ...
    </div>
</div>
```
