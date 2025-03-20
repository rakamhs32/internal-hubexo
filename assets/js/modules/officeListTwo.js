export default {
    init() {
        const toggleSubOfficeList = (event) => {
            event.stopPropagation();
            const mainOfficeList = event.currentTarget.closest('.main-office-list');
            const subOfficeLists = mainOfficeList.querySelectorAll('.sub-office-list');
            subOfficeLists.forEach(list => {
                list.classList.toggle('show');
            });
        };

        const toggleAddressOffice = (event) => {
            event.stopPropagation();
            const subOffice = event.currentTarget.closest('.sub-office');
            const addressOffice = subOffice.querySelector('.address-office');
            addressOffice.classList.toggle('show');
        };

        document.querySelectorAll('.main-office-content').forEach(element => {
            element.addEventListener('click', toggleSubOfficeList);
        });

        document.querySelectorAll('.sub-office-content').forEach(element => {
            element.addEventListener('click', toggleAddressOffice);
        });
    },
    
    destroy() {
        document.querySelectorAll('.main-office-content').forEach(element => {
            element.removeEventListener('click', toggleSubOfficeList);
        });

        document.querySelectorAll('.sub-office-content').forEach(element => {
            element.removeEventListener('click', toggleAddressOffice);
        });
    },
};
