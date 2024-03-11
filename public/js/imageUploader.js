class ImageUploaderAdapter {
    constructor(loader, authToken, csrfToken, uri) {
        this.loader = loader;
        this.authToken = authToken;
        this.csrfToken = csrfToken;
        this.uploadUri = uri;
    }

    upload() {
        return this.loader.file.then(file => {
            return new Promise((resolve, reject) => {
                const formData = new FormData();
                formData.append('image', file);
                fetch(this.uploadUri, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': this.csrfToken,
                        'apiKey': this.authToken
                    },
                    body: formData
                })
                    .then((resp) => (resp.ok ? resp.json() : reject()))
                    .then((data) => {
                        resolve({default: data.path})
                    })
                    .catch((error) => {
                        showToast('error', '', 'Không thể upload image hãy thử lại');
                        reject();
                    })
            });
        });
    }
}
