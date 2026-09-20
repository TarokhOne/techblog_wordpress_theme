document.addEventListener('DOMContentLoaded', function () {

    console.log("Hello World");

    const menuButton = document.querySelector('.mobile-menu-toggle');
    const navigation = document.querySelector('.main-navigation');

    if (!menuButton || !navigation) {
        return;
    }

    menuButton.addEventListener('click', function () {

        console.log('Hamburger clicked');

        navigation.classList.toggle('is-open');

        const isOpen = navigation.classList.contains('is-open');

        menuButton.setAttribute('aria-expanded', isOpen);

    });

});