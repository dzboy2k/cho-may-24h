const notificationContainer = document.getElementById(
    "notifications-container"
);
const notificationBtn = document.querySelectorAll(".notification-btn");
let page = 1;
let last_page = 1;
for (let btn of notificationBtn) {
    btn.addEventListener("click", (e) => {
        notificationContainer.classList.toggle("n-show");
        document.getElementById('profile-dropdown-menu').classList.remove('c-show')
    });
}
const renderNotificationItem = (id, img, content, link, time, read) => {
    const notificationElement = document.createElement('a');
    notificationElement.classList.add('nav-link', 'w-100');
    notificationElement.href = link
    notificationElement.innerHTML = `
        <div data-id="${id}" class="d-flex justify-content-start align-items-center notification-items ${read === 0 ? "unread" : ""}" onclick="readNotification(this)">
            <img src="${img}" class="img-fluid notification-bg object-fit-cover" alt="notification-image"/>
            <div class="d-flex flex-column align-items-start ms-3">
                <p class="subtitle m-0 content--wrap">${content}</p>
                <p class="caption mt-1 neutral-300">${new Date(time).toUTCString()}</p>
            </div>
        </div>
    `;
    return notificationElement;
};
const readNotification = async (self) => {
    const resp = await fetch(notificationApis.readNotification, {
        method: "POST",
        headers: {
            apiKey: authToken,
        },
        body: JSON.stringify({readed: 1, id: self.dataset.id}),
    });
    if (resp.status === 200) {
        self.classList.toggle("unread");
    }
    calcNotificationCount();
};
const calcNotificationCount = () => {
    const unread = document.querySelectorAll(".notification-container .unread");
    const badge = document.getElementById("count_notification");
    const badgeMobile = document.getElementById("count_notification_mobile");
    if (unread.length > 0) {
        badge.classList.remove("hide");
        badgeMobile.classList.remove("hide");
        badgeMobile.innerHTML = unread.length;
        badge.innerHTML = unread.length;
        document.getElementById("no-notif-data")?.classList.add("hide");
    } else {
        badge.classList.add("hide");
        badgeMobile.classList.add("hide");
        document.getElementById("no-notif-data")?.classList.remove("hide");
    }
};

const getListNotification = async (path) => {
    const resp = await fetch(path, {
        headers: {
            apiKey: authToken,
        },
    });
    if (resp.status === 200) {
        const notificationJson = await resp.json();
        last_page = notificationJson.last_page;
        appendToContainer(notificationJson?.data);
    } else {
        showToast("error", "Thông báo", langConfigs.fetchError);
    }
};

const appendToContainer = (items) => {
    items.map((notification) => {
        notificationContainer.appendChild(renderNotificationItem(
                notification?.id,
                notification?.image_path,
                notification?.content,
                notification?.link,
                notification?.created_at,
                notification.readed
            )
        )
    });
    if (items.length <= 0) {
        notificationContainer.innerHTML += `<p class="subtitle text-center my-2" id="no-notif-data">${langConfigs.noData}</p>`;
    }
    if (page + 1 <= last_page) {
        appendLoadMore();
    } else {
        removeLoadMore();
    }
    calcNotificationCount();
}

function getLoadMoreElement() {
    const loadMoreElement = document.createElement('div');
    loadMoreElement.classList.add('text-center', 'my-2');
    loadMoreElement.id = 'btn-load-more';
    loadMoreElement.innerHTML = `<a class="text-decoration-none text-primary fw-semibold subtitle" onclick="loadMore()">${langConfigs.loadMore}</a>`
    return loadMoreElement;
}

function appendLoadMore() {
    notificationContainer.appendChild(getLoadMoreElement());
}

function removeLoadMore() {
    let loadMoreBtn = document.getElementById('btn-load-more');
    if (loadMoreBtn) {
        notificationContainer.removeChild(loadMoreBtn);
    }
}

const loadMore = async () => {
    removeLoadMore();
    if (page === last_page) {
        return;
    }
    page = page + 1 > last_page ? last_page : page + 1;
    const path = `${notificationApis.listNotification}?page=${page}`;
    await getListNotification(path);
};
const prependContainer = (item) => {
    const notification_item = $(
        renderNotificationItem(
            item?.id,
            item.image_path,
            item.content,
            item.link,
            item.created_at,
            item.readed
        )
    );
    $("#notifications-container").prepend(notification_item);
    calcNotificationCount();
};
