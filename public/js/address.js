const baseURL = "https://provinces.open-api.vn/api/";

const renderData = (array, targetElementId, selectedId) => {
    let row = "<option value=''>Chọn</option>";
    if (Array.isArray(array) || array.length > 0) {
        array.forEach((element) => {
            row +=
                `<option ${element.code == selectedId && "selected"} value="${element.code}">${element.name}</option>`;
        });
        document.querySelector("#" + targetElementId).innerHTML = row;
    }
};

const getProvinces = (path, selectedId) => {
    return fetch(path)
        .then((response) => {
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            return response.json();
        })
        .then((data) => {
            renderData(data, "province", selectedId);
        });
};

const getDistricts = (path, selectedId) => {
    return fetch(path)
        .then((response) => {
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            return response.json();
        })
        .then((data) => {
            renderData(data.districts, "district", selectedId);
        });
};

const getWards = (path, selectedId) => {
    return fetch(path)
        .then((response) => {
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            return response.json();
        })
        .then((data) => {
            renderData(data.wards, "ward", selectedId);
        });
};