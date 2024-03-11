function scrollHorizontally(scrollWrapperSelector, prevButtonSelector, nextButtonSelector, itemSelector) {
    const scrollWrapper = document.querySelector(scrollWrapperSelector);
    const scrollPrev = document.querySelector(prevButtonSelector);
    const scrollNext = document.querySelector(nextButtonSelector);
    const itemWidth = document.querySelector(itemSelector).offsetWidth;
    let scrollAmount = 0;

    scrollNext.addEventListener('click', () => {
        if (scrollAmount < scrollWrapper.scrollWidth - scrollWrapper.clientWidth) {
            scrollAmount += itemWidth + 20;
            scrollWrapper.style.transform = `translateX(-${scrollAmount}px)`;
        }
    });

    scrollPrev.addEventListener('click', () => {
        if (scrollAmount > 0) {
            scrollAmount -= itemWidth + 20;
            scrollWrapper.style.transform = `translateX(-${scrollAmount}px)`;
        }
    });
    
}