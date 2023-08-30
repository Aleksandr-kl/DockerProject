
function Footer() {
    return (
        <div className="page-container">
            <div className="content">
                {/* Ваш контент сторінки */}
            </div>
            <footer className="footer-container d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
                <p className="col-md-4 mb-0 text-body-secondary">© 2023 Company, Inc</p>
                <ul className="nav col-md-4 justify-content-end">
                    <li className="nav-item"><a href="#" className="nav-link px-2 text-body-secondary footer-link">Home</a></li>
                    <li className="nav-item"><a href="#" className="nav-link px-2 text-body-secondary footer-link">Features</a></li>
                    <li className="nav-item"><a href="#" className="nav-link px-2 text-body-secondary footer-link">Pricing</a></li>
                    <li className="nav-item"><a href="#" className="nav-link px-2 text-body-secondary footer-link">FAQs</a></li>
                    <li className="nav-item"><a href="#" className="nav-link px-2 text-body-secondary footer-link">About</a></li>
                </ul>
            </footer>
        </div>
    );
}

export default Footer;