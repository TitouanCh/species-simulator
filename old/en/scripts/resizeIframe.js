function resizeIframe(obj) {
	setTimeout(() => { obj.style.height = obj.contentWindow.document.documentElement.scrollHeight + 'px'; }, 100);
}