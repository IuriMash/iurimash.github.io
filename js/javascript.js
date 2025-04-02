document.addEventListener('DOMContentLoaded', function() {
    const CheckSwitch = document.getElementById('MySwitch');
    const body = document.body;
    
    let Theme = localStorage.getItem('theme');

    if (Theme === 'dark') {
        CheckSwitch.checked = true;
    } else {
        CheckSwitch.checked = false;
    }

    function UpdateTheme(theme) {
        body.classList.remove('light', 'dark');
        body.classList.add(theme);
    }

    UpdateTheme(Theme);

    CheckSwitch.addEventListener('change', function() {
        const theme = this.checked ? 'dark' : 'light';
        localStorage.setItem('theme', theme);
        UpdateTheme(theme);
    });
});
