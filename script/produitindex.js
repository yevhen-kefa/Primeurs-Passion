function scrollHorizontally(event) {
    event.preventDefault();
    const delta = Math.max(-1, Math.min(1, event.wheelDelta || -event.detail));
    document.querySelector(".horizontal-scroll").scrollLeft -= delta * 40; // Ajustez la vitesse du défilement ici
}
