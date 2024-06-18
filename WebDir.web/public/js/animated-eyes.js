const sunImage = document.querySelector('.sun-image');
const eyeImages = document.querySelectorAll('.eye-image');
const sunShine = document.querySelector('.sun-shine');


let sunX = 0;
let sunY = 0;


let shineX = 0;
let shineY = 0;

document.addEventListener('mousemove', function (e) {
    // Mouvement du soleil
    const sunRect = sunImage.getBoundingClientRect();
    const centerX = sunRect.left + sunRect.width / 2;
    const centerY = sunRect.top + sunRect.height / 2;
    const deltaX = e.clientX - centerX;
    const deltaY = e.clientY - centerY;
    const maxSunMovement = 10; // Ajuster la distance maximale de déplacement du soleil
    sunX += (deltaX / 180 - sunX) * 0.1; // Ajout d'une inertie pour un mouvement plus fluide
    sunY += (deltaY / 180 - sunY) * 0.1; // Ajout d'une inertie pour un mouvement plus fluide
    sunImage.style.transform = `translate(-50%, -50%) translate(${sunX}px, ${sunY}px)`;

    const shineRect = sunShine.getBoundingClientRect();
    const shinecenterX = shineRect.left + shineRect.width / 2;
    const shinecenterY = shineRect.top + shineRect.height / 2;
    const shinedeltaX = e.clientX - shinecenterX;
    const shinedeltaY = e.clientY - shinecenterY;
    const shinemaxSunMovement = 10; // Ajuster la distance maximale de déplacement du soleil

    shineX += (shinedeltaX / 180 - sunX) * 0.8; // Ajout d'une inertie pour un mouvement plus fluide
    shineY += (shinedeltaY / 180 - sunY) * 0.8; // Ajout d'une inertie pour un mouvement plus fluide
    sunShine.style.transform = `translate(-50%, -50%) translate(${shineX}px, ${sunY}px)`;



    // Mouvement des yeux
    eyeImages.forEach(function (eyeImage) {
        const rect = eyeImage.getBoundingClientRect();
        const eyeCenterX = rect.left + rect.width / 2;
        const eyeCenterY = rect.top + rect.height / 2;
        const eyeDeltaX = e.clientX - eyeCenterX;
        const eyeDeltaY = e.clientY - eyeCenterY;
        const maxEyeMovement = 5; // Ajuster la distance maximale de déplacement des yeux
        const translateEyeX = Math.min(Math.max(eyeDeltaX / 30, -maxEyeMovement), maxEyeMovement);
        const translateEyeY = Math.min(Math.max(eyeDeltaY / 30, -maxEyeMovement), maxEyeMovement);
        eyeImage.style.transform = `translate(-50%, -50%) translate(${translateEyeX}px, ${translateEyeY}px)`;
    });
});
