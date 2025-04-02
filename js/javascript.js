document.addEventListener('DOMContentLoaded', function() {
    const CheckSwitch = document.getElementById('MySwitch');
    const body = document.body
    const Theme = localStorage.getItem('theme');

    if (Theme === 'dark') {
        ButtonSwitch.checked = true;
        UpdateTheme();
    } else {
        ButtonSwitch.checked = false;
        UpdateTheme();
    }

    CheckSwitch.addEventListener('change', function() {
        if (this.checked) {
            localStorage.setItem('theme', 'dark');
            UpdateTheme();
        } else {
            localStorage.setItem('theme', 'light');
            UpdateTheme();
        }
    });

    function UpdateTheme() {
        body.classList.remove('light', 'dark');
        body.classList.add(theme);
    }
});