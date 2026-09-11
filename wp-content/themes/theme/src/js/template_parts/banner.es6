document.addEventListener('DOMContentLoaded', () => {
    const bannerButton = document.querySelector('.banner__button');
    const bannerSection = document.querySelector('.banner');

    if (!bannerButton || !bannerSection) return;

    bannerButton.addEventListener('click', (e) => {
        e.preventDefault(); 

        bannerButton.style.opacity = '0';

        const url = new URL(window.location);
        url.searchParams.set('masterplan', '1');
        window.history.pushState({}, '', url);

        setTimeout(() => {
            bannerSection.classList.add('hidden');
            setTimeout(() => {
                const iframe = document.querySelector('.spinner iframe');
                if (iframe) {
                    iframe.contentWindow.postMessage(
                        { type: "ACTIVE_BLINK" },
                        window.location.origin
                    );
                }
            }, 300); 

            setTimeout(() => {
                bannerSection.classList.add('dn');
            }, 1000); 
        }, 1500);
    });
});