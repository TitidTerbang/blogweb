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
          throw new Error("Data format from API is incorrect");
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
      return (
        <div className="flex justify-center items-center h-screen">
            <div className="animate-spin rounded-full h-16 w-16 border-t-2 border-b-2 border-blue-500"></div>
        </div>
      );
    }

  if (error) {
    return (
        <div className="flex justify-center items-center h-screen">
          <p className="text-red-500 font-poppins text-center">
            Error fetching articles: {error.message}
          </p>
        </div>
      );
  }

  return (
    <div className="font-poppins bg-background min-h-screen py-10">
      <div className="container mx-auto px-4">
        <h1 className="text-3xl font-bold mb-6 text-center text-primary">
          Daftar Artikel
        </h1>
        <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
          {articles.map((article) => (
            <div
              key={article.id}
              className="bg-white shadow rounded-md overflow-hidden hover:shadow-lg transition duration-300 ease-in-out"
            >
                <div className="p-4">
                    <h2 className="text-lg font-medium text-gray-800 mb-2">
                    {article.title}
                    </h2>
                    <Link
                        to={`/article/${article.id}`}
                         className="text-primary hover:text-blue-700 transition duration-300 ease-in-out"
                     >
                        Read More
                     </Link>
                </div>
            </div>
          ))}
        </div>
      </div>
    </div>
  );
}

export default Article;