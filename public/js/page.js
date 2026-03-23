
const navElement = document.querySelector("header nav");
const navToggleButton = document.querySelector(".menu-toggle");
const navLinks = document.querySelectorAll("header nav ul a");

if (navElement && navToggleButton) {
    navToggleButton.addEventListener("click", () => {
        const isOpen = navElement.classList.toggle("is-open");
        navToggleButton.setAttribute("aria-expanded", isOpen ? "true" : "false");
    });

    navLinks.forEach((link) => {
        link.addEventListener("click", () => {
            navElement.classList.remove("is-open");
            navToggleButton.setAttribute("aria-expanded", "false");
        });
    });

    window.addEventListener("resize", () => {
        if (window.innerWidth > 980) {
            navElement.classList.remove("is-open");
            navToggleButton.setAttribute("aria-expanded", "false");
        }
    });
}

// Fitur dashboard
const btn = document.querySelector(".fitur-btn");
const content = document.querySelector(".fitur-content");

if (btn && content) {
    btn.addEventListener("click", () => {
        content.classList.toggle("show");
    });
}

// Fade-in animation when elements enter viewport.
const fadeElements = document.querySelectorAll(".scroll-fade");

if (fadeElements.length > 0) {
    const fadeObserver = new IntersectionObserver(
        (entries, observer) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("show");
                    observer.unobserve(entry.target);
                }
            });
        },
        {
            threshold: 0.2,
            rootMargin: "0px 0px -40px 0px",
        }
    );

    fadeElements.forEach((element) => fadeObserver.observe(element));
}

// Sticky feature preview switching.
const featureItems = document.querySelectorAll(".feature-item[data-feature]");
const featurePreviews = document.querySelectorAll(".preview-screen[data-preview]");
const featureModal = document.querySelector("#feature-modal");
const featureModalContent = document.querySelector(".feature-modal-content");
const featureModalCloseTriggers = document.querySelectorAll("[data-close-feature-modal]");

if (featureItems.length > 0 && featurePreviews.length > 0) {
    const isMobileFeatureMode = () => window.matchMedia("(max-width: 900px)").matches;

    const closeFeatureModal = () => {
        if (!featureModal) {
            return;
        }

        featureModal.classList.remove("is-open");
        featureModal.setAttribute("aria-hidden", "true");
        document.body.classList.remove("modal-open");
    };

    const openFeatureModal = (key) => {
        if (!featureModal || !featureModalContent) {
            return;
        }

        const selectedPreview = Array.from(featurePreviews).find(
            (preview) => preview.dataset.preview === key
        );

        if (!selectedPreview) {
            return;
        }

        featureModalContent.innerHTML = selectedPreview.innerHTML;
        featureModal.classList.add("is-open");
        featureModal.setAttribute("aria-hidden", "false");
        document.body.classList.add("modal-open");
    };

    const activateFeature = (key) => {
        featureItems.forEach((item) => {
            const isActive = item.dataset.feature === key;
            item.classList.toggle("is-active", isActive);
            item.setAttribute("aria-selected", isActive ? "true" : "false");
            item.setAttribute("tabindex", isActive ? "0" : "-1");
        });

        featurePreviews.forEach((preview) => {
            preview.classList.toggle("is-active", preview.dataset.preview === key);
        });
    };

    featureItems.forEach((item) => {
        item.addEventListener("click", () => {
            const selectedKey = item.dataset.feature;
            activateFeature(selectedKey);

            if (isMobileFeatureMode()) {
                openFeatureModal(selectedKey);
            }
        });

        item.addEventListener("keydown", (event) => {
            if (event.key === "Enter" || event.key === " ") {
                event.preventDefault();
                const selectedKey = item.dataset.feature;
                activateFeature(selectedKey);

                if (isMobileFeatureMode()) {
                    openFeatureModal(selectedKey);
                }
            }
        });
    });

    featureModalCloseTriggers.forEach((trigger) => {
        trigger.addEventListener("click", closeFeatureModal);
    });

    window.addEventListener("keydown", (event) => {
        if (event.key === "Escape") {
            closeFeatureModal();
        }
    });

    window.addEventListener("resize", () => {
        if (!isMobileFeatureMode()) {
            closeFeatureModal();
        }
    });
}
