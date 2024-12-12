import React, { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';

function Article() {
  const [articles, setArticles] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    const fetchArticles = async () => {
      setLoading(true);
      setError(null);
      try {
        const response = await fetch('http://localhost/blogweb/backend/api/articles/get.php');
        if (!response.ok) {
          throw new Error(`HTTP error! Status: ${response.status}`);
        }
        const data = await response.json();
        if (data && data.data) {
          setArticles(data.data);
        } else {
            throw new Error("Data format from API is incorrect")
        }


      } catch (err) {
        setError(err);
        console.error('Failed to fetch articles', err);
      } finally {
        setLoading(false);
      }
    };

    fetchArticles();
  }, []);

  if (loading) {
    return <p>Loading articles...</p>;
  }

  if (error) {
    return <p>Error fetching articles: {error.message}</p>;
  }


  return (
    <div>
      <h1>Daftar Artikel</h1>
      <ul>
        {articles.map((article) => (
          <li key={article.id}>
            <Link to={`/article/${article.id}`}>{article.title}</Link>
          </li>
        ))}
      </ul>
    </div>
  );
}

export default Article;