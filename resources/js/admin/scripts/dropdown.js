window.dropdown = function () {
    return {
        isOpen: false,
        toggle() {
            this.isOpen = !this.isOpen;
        },
    }
}
