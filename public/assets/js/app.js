function adsAreBlocked() {
    if (isAdBlockActive) {
        console.log("The visitor is blocking ads");
        return true;
    }
    return false;
}