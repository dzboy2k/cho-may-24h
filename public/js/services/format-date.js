function formatDate(dateStr, langConfigs) {
    const d = new Date(dateStr);
    const date = d.getDate();
    const month = d.getMonth();
    const year = d.getFullYear();
    const hours = d.getHours();
    const minutes = d.getMinutes();
    const now = new Date();
    const yearsBetween = now.getFullYear() - d.getFullYear();
    const monthsBetween = now.getMonth() - d.getMonth();
    const daysBetween = now.getDate() - d.getDate();
    const hoursBetween = now.getHours() - d.getHours();
    const minutesBetween = now.getMinutes() - d.getMinutes();
    const {nowText, dateText, hourText, minuteText, beforeText, atText} = langConfigs;

    if (yearsBetween === 0) {
        if (monthsBetween === 0) {
            if (daysBetween === 0) {
                if (hoursBetween === 0) {
                    if (minutesBetween === 0) {
                        return nowText;
                    } else {
                        return minutesBetween + ' ' + minuteText + ' ' + beforeText;
                    }
                } else {
                    return hoursBetween + ' ' + hourText + ' ' + beforeText;
                }
            } else {
                if (daysBetween < 7) {
                    return daysBetween + ' ' + dateText + ' ' + beforeText;
                }
            }
        }
    }
    // return dateText + ' ' + date + '/' + month + '/' + year + ' ' + hours + 'h' + minutes + 'p';
    return `${dateText} ${date}/${month}/${year} ${atText} ${hours}${hourText}${minutes}${minuteText}`;
};
