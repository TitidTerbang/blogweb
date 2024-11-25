import {BrowserRouter as Router, Route, Link, Routes} from "react-router-dom";

import home from "./pages/home"
import article from "./pages/article"
import Login from "./pages/login.jsx";
import dashboard from "./pages/dashboard"

// Import css
import "./index.css"

function App() {
    return (
        <div className="App">
            <Router>
                <Routes>
                    <Route exact path="/" element={home()}/>
                    <Route exact path="article" element={article()}/>
                    <Route exact path="login" element={Login()}/>
                    <Route exact path="dashboard" element={dashboard()}/>
                </Routes>
                <div className="list">
                    <ul>
                        <li><Link to="/">Home</Link></li>
                        <li><Link to="article">Article</Link></li>
                        <li><Link to="login">Login</Link></li>
                        <li><Link to="dashboard">Dashboard</Link></li>
                    </ul>
                </div>
            </Router>
        </div>
    );
}

export default App;