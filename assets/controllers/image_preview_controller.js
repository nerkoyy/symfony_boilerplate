import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    static targets = ["select", "preview"];

    preview() {
        const selectedOption = this.selectTarget.selectedOptions[0];
        if (selectedOption) {
            const imageUrl = selectedOption.textContent.trim();
            this.previewTarget.src = imageUrl;
            this.previewTarget.style.display = "block";
        }
    }
}
