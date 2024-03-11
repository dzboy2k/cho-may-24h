function readMore(fullTextSelector, shortTextSelector, readMoreLinkSelector, maxLength) {
    const fullText = document.querySelector(fullTextSelector);
    const shortText = document.querySelector(shortTextSelector);
    const readMoreLink = document.querySelector(readMoreLinkSelector);

    if (fullText.textContent.length > maxLength) {
        readMoreLink.classList.remove('d-none');
        
        readMoreLink.addEventListener('click', function(event) {
            event.preventDefault();

            if (shortText.classList.contains('d-none')) {
                shortText.classList.remove('d-none');
                fullText.classList.add('d-none');
                readMoreLink.textContent = lang.readMore;
            } else {
                shortText.classList.add('d-none');
                fullText.classList.remove('d-none');
                readMoreLink.textContent = lang.readLess;
            }
        });
    }
}