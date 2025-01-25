// Check if user has a theme set and if not, check if system is set to dark
const checkbox = document.querySelector('.theme-controller');
const body = document.body;

// Icons
const sunIcon = document.querySelector('.sun');
const moonIcon = document.querySelector('.moon');

// Check if user has a theme set and if not, check if system is set to dark
const userTheme = localStorage.getItem('theme');
const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches;

// Icon Toggling
const iconToggle = () => {
    sunIcon.classList.toggle('swap-on');
    moonIcon.classList.toggle('swap-off');
    };

// Check if user has a theme set and if not, check if system is set to dark
const themeCheck = () => {
    if (userTheme === 'dark' || (!userTheme && systemTheme)) {
        document.documentElement.classList.add('dark');
        sunIcon.classList.toggle('swap-on');
        sunIcon.classList.toggle('swap-off', !sunIcon.classList.contains('swap-on')); // Toggle swap-off based on swap-on
        return;
    }
        moonIcon.classList.toggle('swap-on');
        moonIcon.classList.toggle('swap-off', !moonIcon.classList.contains('swap-on')); // Toggle swap-off based on swap-on
    }; 

/*/ Manual Theme Switch
    const themeSwitch = () => {
     if(document.documentElement.classList.contains('dark')){
        document.documentElement.classList.remove('dark');
        localStorage.setItem("theme", "light");
        iconToggle();
     }
        document.documentElement.classList.add("dark");
        localStorage.setItem("theme", "dark");
        iconToggle();
    };

sunIcon.addEventListener("click",() => {
    themeSwitch();
});

moonIcon.addEventListener("click",() => {
    themeSwitch();
});

themeCheck(); 



    checkbox.addEventListener('click', function () {
      if (checkbox.checked) {
        body.classList.add('dark');
      } else {
        body.classList.remove('dark');
      }
    }); */
