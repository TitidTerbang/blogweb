import React, { useState, useEffect } from 'react';
import { useParams } from 'react-router-dom';

function ArticleDetail() {
    const { id } = useParams();
    const [article, setArticle] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);


  useEffect(() => {
    const fetchArticle = async () => {
        setLoading(true);
        setError(null);
        try {
             const response = await fetch(`http://localhost/blogweb/backend/api/articles/get.php?id=${id}`);
             if(!response.ok){
                 if(response.status === 404) {
                      setError({ message: 'Article not found' });
                 } else{
                     throw new Error(`HTTP error! Status: ${response.status}`);
                 }
             } else {
                 const data = await response.json();
                 if(data && data.data) {
                      setArticle(data.data);
                 } else {
                      throw new Error("Data format from API is incorrect");
                 }
             }
         } catch (err) {
           setError(err);
           console.error('Failed to fetch article', err);
        } finally {
            setLoading(false);
        }
    }
      fetchArticle();
    }, [id]);


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
             Error fetching article: {error.message}
          </p>
        </div>
      );
  }

   if(!article){
        return <p className="text-center">Article not found</p>
   }
  return (
    <div className="font-poppins bg-background min-h-screen py-10">
      <div className="container mx-auto px-4">
        <h1 className="text-3xl font-bold mb-4 text-center text-primary">
          {article.title}
        </h1>
           {article.image_url && (
              <img
                  src={article.image_url}
                  alt={article.title}
                  className="w-full h-96 object-cover rounded-md mb-6"
               />
             )}
          <div className="prose max-w-none" dangerouslySetInnerHTML={{ __html: article.content }}>
          </div>
      </div>
    </div>
  );
}

export default ArticleDetail;