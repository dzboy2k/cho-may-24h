async function updateContact(message) {
    const contactEl = document.getElementById("contact-" + message.sender_id);
    if (!contactEl) {
        let contact = await getContactById(message.contact_id);
        if (!contact) {
            await fetchNewContact(message.sender_id);
        }
        await loadContactWithoutLoader(authToken);
        moveContactToTop(message?.sender_id);
        return true;
    }
    return false;
}

async function getContactById(id) {
    try {
        const resp = await fetch(chatApis.getContactById + id, {
            method: "GET",
            headers: {
                apiKey: authToken,
            },
        });
        if (resp.status === 200) {
            return await resp.json();
        }
        return null;
    } catch (e) {
        console.log("cannot get contact by id: " + id, e);
    }
}

async function fetchNewContact(receiver_id) {
    try {
        const resp = await fetch(chatApis.fetchNewContact, {
            method: "POST",
            headers: {
                apiKey: authToken,
            },
            body: JSON.stringify({receiver_id}),
        });
        return await resp.json();
    } catch (e) {
        console.log(e);
    }
}
