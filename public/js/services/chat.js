uploader.addEventListener("change", function () {
  renderPreview();
});

messageInput.addEventListener("keydown", function (event) {
  if (event.key === "Enter" && !event.shiftKey) {
    event.preventDefault();
    submitMessage();
  }
});

btnSendMessage.addEventListener("click", submitMessage);
function removeChatBadge() {
  document.getElementById("chat-badge").classList.add("hide");
}
async function submitMessage(event) {
  if (msgInput.value.trim() === "") {
    return;
  }
  await sendAMessage(
    msgInput.value,
    msgInput.dataset.receiver,
    msgInput.dataset.contact,
    authToken
  );
  moveContactToTop(msgInput.dataset.receiver);
}

function renderPreview() {
  previewContainer.innerHTML = "";
  const files = uploader.files;
  for (let file of files) {
    let uri = URL.createObjectURL(file);
    let imgHtml = `<div class="col-2 col-md-2 p-2">
                        <div class="position-relative">
                            <img src="${uri}" class="img-fluid w-100 rounded object-fit-cover"/>
                            <span data-name='${file.name}' class="position-absolute small delete-img-btn btn-close" onclick="removeImage(this)"></span>
                        </div>
                    </div>`;
    previewContainer.innerHTML += imgHtml;
  }

  if (files.length > 0) {
    previewContainer.classList.remove("d-none");
  } else {
    previewContainer.classList.add("d-none");
  }
}

function getCloneFileList(listFile) {
  const dataTransfer = new DataTransfer();
  for (let file of listFile) {
    dataTransfer.items.add(file);
  }
  return dataTransfer;
}

function removeImage(self) {
  const dataTransfer = getCloneFileList(uploader.files);
  let name = self.dataset.name;
  for (let i = 0; i < dataTransfer.items.length; i++) {
    if (dataTransfer.files[i].name === name) {
      dataTransfer.items.remove(i);
    }
  }
  uploader.files = dataTransfer.files;
  renderPreview();
}

async function loadContactWithoutLoader(token) {
  try {
    removeChatBadge();
    const resp = await fetch(chatApis.loadContact, {
      method: "GET",
      headers: {
        apiKey: token,
      },
    });
    listContacts = (await resp.json()).data;
    await renderChatContact();
  } catch (e) {
    console.log("cannot get list contact", e);
  }
}

async function loadContact(token) {
  try {
    removeChatBadge();
    const resp = await fetch(chatApis.loadContact, {
      method: "GET",
      headers: {
        apiKey: token,
      },
    });
    loader.classList.toggle("hide");
    listContacts = (await resp.json()).data;
    await renderChatContact();
  } catch (e) {
    console.log("cannot get list contact", e);
  }
}

async function loadMessage(contact_id, container) {
  try {
    if (contact_id) {
      const resp = await fetch(chatApis.loadMessage.replace("-1", contact_id), {
        method: "GET",
        headers: {
          apiKey: authToken,
        },
      });
      const messages = await resp.json();
      renderMessage(messages, container);
    }
  } catch (e) {
    console.log(e);
  }
}

function clearContactList() {
  while (listContactContainer.firstChild) {
    listContactContainer.removeChild(listContactContainer.firstChild);
  }
  while (listContactMobileContainer.firstChild) {
    listContactMobileContainer.removeChild(
      listContactMobileContainer.firstChild
    );
  }
  while (listContactContentContainer.firstChild) {
    listContactContentContainer.removeChild(
      listContactContentContainer.firstChild
    );
  }
}

async function renderChatContact() {
  if (newContact) {
    listContacts.unshift(newContact);
  }
  removeDuplicate();
  const amountContact = listContacts.length;
  for (let i = 0; i < amountContact; i++) {
    await renderAnContact(listContacts[i], i === 0);
  }
  loadIsBlank();
  createMessageForPostIfHave();
}

function createMessageForPostIfHave() {
  if (postData) {
    let msg = chatLangs.msgWithPost;
    msgInput.value = msg;
  }
}

function removeDuplicate() {
  const uniqueContacts = listContacts.reduce((acc, item) => {
    const existingItem = acc.find(
      (element) => element.receiver_id === item.receiver_id
    );
    if (!existingItem) {
      acc.push(item);
    }
    return acc;
  }, []);
  listContacts = uniqueContacts;
}

function getContactEl(contact, isActive) {
  const contactEl = createElement("a", {
    onclick: "changeMessageTab(this)",
    "data-contact": contact?.id ? contact.id : null,
    "data-receiver": contact.receiver_id,
    id: "contact-" + (contact?.receiver_id ? contact.receiver_id : null),
    "data-bs-toggle": "tab",
    "data-bs-target": "#chat-content-" + contact.receiver_id,
    "data-readed": contact.readed !== 0,
    class: `list-group-item list-group-item-action rounded-0 border-0 ${
      isActive ? "active" : ""
    } contact`,
  });
  contactEl.innerHTML = `
        <div class="d-flex contact-info-${contact?.id}">
            <img src="${
              contact?.image_path
            }" class="avatar" alt="receiver_avt"/>
            <div class="d-flex ms-1 row justify-content-center align-self-center">
                <span class="subtitle text-info">${
                  contact?.receiver_name
                }</span>
            </div>
            <span class="position-absolute shadow-lg bagde-pos translate-middle p-2 bg-danger border border-light rounded-circle ${
              contact.readed !== 0 ? "visually-hidden" : ""
            }" id="contact-unread-${contact.id}"></span>
        </div>
    `;
  return contactEl;
}

function getContactContentEl(contact, isActive) {
  let contactContentEl = createElement("div", {
    class: `tab-pane fade show ${isActive ? "active" : ""}`,
    id: `chat-content-${contact.receiver_id}`,
  });
  contactContentEl.innerHTML = `
        <div class="d-flex row py-2 border-0 border-bottom">
            <div class="d-flex justify-content-between py-2">
                <div class="d-flex collumn">
                    <button class="btn d-md-none ps-0 border-0" type="button"
                            data-bs-toggle="offcanvas" data-bs-target="#offListMessager"
                            aria-controls="offListMessager">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <div class="row justify-content-center align-items-center">
                        <span class="subtitle text-info">${
                          contact.receiver_name
                        }</span>
                    </div>
                </div>
                <div class="dropdown">
                    <button class="btn btn-link" type="button" id="menu-settings"
                            data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-ellipsis text-black"></i>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="menu-settings">
                        <li><a class="dropdown-item" href="${
                          chatApis.profile +
                          contact.receiver_referral_code.trim()
                        }"><i class="fal fa-user pe-1"></i>${
    chatLangs.profile
  }</a></li>
                    </ul>
                </div>
            </div>
            ${
              postData && contact.receiver_id == postData.author_id
                ? `
                <div class="py-2">
                    <a href="#" class="text-decoration-none link-dark d-flex row border-top">
                        <span class="subtitle mt-2">${postData.title}</span>
                        <span class="subtitle text-danger">${postData.price}đ</span>
                    </a>
                </div>`
                : ""
            }
            </div>
        <div class="pt-3 pe-3 scrollable-message" id="chat-message-${
          contact.receiver_id
        }">
           <div class="position-absolute top-0 start-0 z-2 w-100 h-100 bg-white d-flex justify-content-center align-items-center hide loader">
                <div class="spinner-border" role="status">
                </div>
            </div>
        </div>
    `;
  return contactContentEl;
}

async function renderAnContact(contact, isActive, nextActions) {
  listContactContainer.appendChild(getContactEl(contact, isActive));
  listContactMobileContainer.appendChild(getContactEl(contact, isActive));
  listContactContentContainer.appendChild(
    getContactContentEl(contact, isActive)
  );
  if (isActive) {
    await loadMessage(contact.id, $(`#chat-message-${contact.receiver_id}`));
    msgInput.dataset.contact = contact.id ? contact.id : null;
    msgInput.dataset.receiver =
      contact.user_id === userId ? contact.receiver_id : contact.user_id;
  }
  nextActions?.();
}

function checkIsEmptyContact() {
  return listContactContainer.children.length === 0;
}

async function deleteContact(id) {
  try {
    loader.classList.add("hide");
    if (!id) {
      return;
    }
    const configs = {
      method: "GET",
      headers: {
        apiKey: authToken,
      },
    };
    const resp = await fetch(chatApis.deleteChat.replace("-1", id), configs);
    if (resp.status < 200 || resp.status > 300) {
      showToast("error", chatLangs.canNotDelete);
    }
    await loadContact(authToken);
    loader.classList.remove("hide");
  } catch (e) {
    console.log("cannot delete contact", e);
  }
}

function loadIsBlank() {
  if (listContacts.length < 1) {
    document.getElementById("blank_contact").classList.remove("hide");
    document.getElementById("chat-content").classList.add("hide");
  } else {
    document.getElementById("blank_contact").classList.add("hide");
    document.getElementById("chat-content").classList.remove("hide");
  }
}

function renderMessage(messages, container) {
  let msgCount = messages.length;
  for (let i = 0; i < msgCount; i++) {
    let isSender = messages[i].sender_id === userId;
    renderAnMessage(isSender, messages[i], container);
  }
}

function getMessageNodes(sender, message) {
  let messageNodes = [];
  if (message.image_path) {
    let imgContainer = createElement("div", {
      class: `d-flex ${
        sender ? "justify-content-end" : "justify-content-start pb-1 pt-0"
      } message`,
    });
    imgContainer.innerHTML = ` <img src='${message.image_path}' class="msg-img rounded"/>`;
    messageNodes.push(imgContainer);
  }
  if (message.message !== "") {
    let msgNode = createElement("div", {
      class: `mw-80 ${sender ? "ms-auto" : "me-auto"} d-flex ${
        sender ? "justify-content-end" : "justify-content-start"
      }  py-1 message`,
    });
    msgNode.innerHTML = `
            <div class="p-2 rounded ${
              sender ? "bg-primary" : "bg-neutral-100"
            } w-45">
                <p class="subtitle mb-0 neutral-400 ${
                  sender ? "text-white" : "text-black"
                }">${message.message}</p>
            </div>
        `;
    messageNodes.push(msgNode);
  }
  return messageNodes;
}

function renderAnMessage(sender, message, container) {
  readContactCl(message?.contact_id);
  let messageNodes = getMessageNodes(sender, message);
  for (let msg of messageNodes) {
    container.append(msg);
  }
  container.scrollTop(container[0].scrollHeight);
}

function removeDaftContact() {
  $("#contact-null").remove();
  $("#chat-content-null").remove();
}

async function sendAMessage(message_content, receiver_id, contact_id, token) {
  const formData = new FormData();
  if (uploader.files.length > 0) {
    formData.append("media", uploader.files[0]);
  }
  formData.append("message", message_content);
  formData.append("receiver_id", receiver_id);
  formData.append("contact_id", contact_id);
  const resp = await fetch(chatApis.sendMessage, {
    method: "POST",
    headers: {
      apiKey: token,
    },
    body: formData,
  });
  if (resp.status >= 200 && resp.status < 400) {
    const message = await resp.json();
    msgInput.value = "";
    uploader.value = null;
    previewContainer.innerHTML = "";
    if (!contact_id) {
      removeContact(receiver_id);
      let contact = await fetchNewContact(receiver_id);
      await renderAnContact(contact, true, loadIsBlank);
    } else {
      renderAnMessage(true, message, $("#chat-message-" + message.receiver_id));
    }
    moveContactToTop(message.receiver_id);
  }
}

function readContactCl(id) {
  document.getElementById("contact-unread-undefine")?.classList?.add("hide");
  document.getElementById("contact-unread-" + id)?.classList.add("hide");
}

function removeContact(id) {
  document.getElementById("contact-" + id).remove();
}

async function changeMessageTab(self) {
  const messageCount = document.querySelectorAll(
    "#chat-message-" + self.dataset.receiver + " .message"
  );
  msgInput.value = "";
  if (messageCount.length <= 0) {
    await loadMessage(
      self.dataset.contact,
      $("#chat-message-" + self.dataset.receiver)
    );
  }
  document
    .getElementById("contact-unread-" + self.dataset.contact)
    ?.classList.add("hide");
  msgInput.dataset.contact = self.dataset.contact;
  msgInput.dataset.receiver = self.dataset.receiver;
  if (self.dataset.readed === "false") {
    await readContact(self.dataset.contact);
  }
}

async function readContact(contact_id) {
  try {
    await fetch(chatApis.readContact.replace("-1", contact_id), {
      method: "GET",
      headers: {
        apiKey: authToken,
      },
    });
  } catch (e) {
    console.log(e);
  }
}

function moveContactToTop(contactId) {
  const contactElement = document.getElementById(`contact-${contactId}`);
  if (contactElement) {
    contactElement?.remove();
    listContactContainer.prepend(contactElement);
  }
}

(async function init() {
  await loadContact(authToken);
})();
