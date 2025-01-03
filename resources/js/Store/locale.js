import { defineStore } from "pinia";

const savedState = JSON.parse(localStorage.getItem("appLocale")) || {
    locale: "en",
    country: "United States",
    flag: "@assets/images/flags/us.svg",
};

export const useLocaleStore = defineStore("locale", {
    state: () => savedState,
    actions: {
        setLocale(locale) {
            this.locale = locale;
            this.saveState();
        },
        setCountry(country) {
            this.country = country;
            this.saveState();
        },
        setFlag(flag) {
            this.flag = flag;
            this.saveState();
        },
        saveState() {
            localStorage.setItem("appLocale", JSON.stringify(this.$state));
        },
    },
});
