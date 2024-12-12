import { BrowserRouter as Router, Route, Link, Routes } from "react-router-dom";

import Home from "./pages/Home";
import Article from "./pages/article";
import Login from "./pages/login.jsx";
import Dashboard from "./pages/dashboard";
import ArticleDetail from "./pages/ArticleDetail.jsx";

// Import css
import "./index.css";

function App() {
  return (
    <div className="App font-poppins">
      <Router>
        <nav className="bg-gray-800 p-4">
          <div className="container mx-auto flex items-center justify-between">
            <Link to="/" className="text-white font-bold text-xl">
            <div className="text-white font-bold text-xl">
              My Blog
            </div>
            </Link>
            <ul className="flex space-x-6">
              <li>
                <Link
                  to="/"
                  className="text-gray-300 hover:text-white transition duration-300"
                >
                  Home
                </Link>
              </li>
              <li>
                <Link
                  to="/article"
                  className="text-gray-300 hover:text-white transition duration-300"
                >
                  Article
                </Link>
              </li>
              <li>
                <Link
                  to="/login"
                  className="text-gray-300 hover:text-white transition duration-300"
                >
                  Login
                </Link>
              </li>
              <li>
                <Link
                  to="/dashboard"
                  className="text-gray-300 hover:text-white transition duration-300"
                >
                  Dashboard
                </Link>
              </li>
            </ul>
          </div>
        </nav>
        <Routes>
          <Route exact path="/" element={<Home />} />
          <Route exact path="/article" element={<Article />} />
          <Route exact path="/login" element={<Login />} />
          <Route exact path="/dashboard" element={<Dashboard />} />
          <Route exact path="/article/:id" element={<ArticleDetail />} />
        </Routes>
      </Router>
    </div>
  );
}

export default App;