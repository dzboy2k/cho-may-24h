const MONTHS = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Jan', 'Sep', 'Oct', 'Nov', 'Dec'];
const DEFAULT_DELAY = 3000;

function createElement(tagName, attributes) {
    let element = document.createElement(tagName);
    for (let key in attributes) {
        if (attributes.hasOwnProperty(key)) {
            element.setAttribute(key, attributes[key]);
        }
    }
    return element;
}

function copyText(elementId) {
    let element = document.querySelector(elementId);
    let textToCopy = element.textContent || element.innerText;
    let textarea = document.createElement("textarea");

    textarea.value = textToCopy;
    document.body.appendChild(textarea);
    textarea.select();
    textarea.setSelectionRange(0, 99999);
    document.execCommand("copy");
    document.body.removeChild(textarea);
    showToast('success', 'Thông báo', 'Copy thành công', {position: 'topRight'});
}

function copyInputValue(sourceSelector, destinationSelector) {
    const sourceInput = document.querySelector(sourceSelector);
    const destinationInput = document.querySelector(destinationSelector);

    sourceInput.addEventListener("input", function () {
        const inputValue = sourceInput.value;
        destinationInput.value = inputValue;
    });
}


function ImageUploaderPlugin(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
        return new ImageUploaderAdapter(loader, authToken, csrfToken, uploadApi);
    }
}

function formatCurrency(coin) {
    return coin.toLocaleString('it-IT', {style: 'currency', currency: 'VND'});
}

String.prototype.toSlug = function (sep) {
    let slug = this.toLowerCase();
    slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
    slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
    slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
    slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
    slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
    slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
    slug = slug.replace(/đ/gi, 'd');
    slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
    slug = slug.replace(/ /gi, sep);
    slug = slug.replace(/\-\-\-\-\-/gi, sep);
    slug = slug.replace(/\-\-\-\-/gi, sep);
    slug = slug.replace(/\-\-\-/gi, sep);
    slug = slug.replace(/\-\-/gi, sep);
    slug = '@' + slug + '@';
    slug = slug.replace(/\@\-|\-\@|\@/gi, '');
    return slug;
};

const showToast = (type, title, msg, options) => {
    let toastOptions = {
        title,
        message: msg,
        ...options,
    };
    switch (type) {
        case "info":
            iziToast.info(toastOptions);
            break;
        case "success":
            iziToast.success(toastOptions);
            break;
        case "warning":
            iziToast.warning(toastOptions);
            break;
        case "error":
            iziToast.error(toastOptions);
            break;
        default:
            iziToast.show(toastOptions);
    }
};

document.addEventListener("DOMContentLoaded", function () {
    const dropdowns = document.querySelectorAll(".profile-dropdown");
    for (let dropdown of dropdowns) {
        dropdown.addEventListener("click", (e) => {
            let dropdownMenu = document.getElementById(dropdown.dataset.target);
            dropdownMenu.classList.toggle("c-show");
            document.getElementById("notifications-container").classList.remove('n-show')
        });
    }
});

function openModal(selector, onModalOpen) {
    const targetModal = $(selector);

    targetModal.modal('show');
    onModalOpen?.(targetModal);
}

function timeAgo(time) {
    const currentTime = new Date();
    const timeStamp = new Date(time);

    const timeDifferenceInSeconds = Math.floor((currentTime - timeStamp) / 1000);
    if (timeDifferenceInSeconds < 60) {
        return `${timeDifferenceInSeconds} second${timeDifferenceInSeconds === 1 ? '' : 's'} ago`;
    } else if (timeDifferenceInSeconds < 3600) {
        const minutes = Math.floor(timeDifferenceInSeconds / 60);
        return `${minutes} minute${minutes === 1 ? '' : 's'} ago`;
    } else if (timeDifferenceInSeconds < 86400) {
        const hours = Math.floor(timeDifferenceInSeconds / 3600);
        return `${hours} hour${hours === 1 ? '' : 's'} ago`;
    } else {
        const days = Math.floor(timeDifferenceInSeconds / 86400);
        return `${days} day${days === 1 ? '' : 's'} ago`;
    }
}

async function fetchWithRetry(uri, configs, delay, callbackWithSuccess, callBackWhenRetry, callbackWithFailed, time = 0) {
    try {
        if (time === 3) {
            return;
        }
        time++;
        const resp = await fetch(uri, configs);
        if (resp.status < 200 || resp.status > 300) {
            setTimeout(() => {
                callBackWhenRetry();
                return fetchWithRetry(uri, configs, delay, callbackWithSuccess, callbackWithFailed, time)
            }, delay ? delay : 3000);
        }
        const jsonData = await resp.json();
        return callbackWithSuccess?.(jsonData);
    } catch (e) {
        if (callbackWithFailed) {
            callbackWithFailed?.(e)
        }
    }
}
