// src/components/ArticleDetail.jsx
import React from 'react';
import { useParams } from 'react-router-dom';

const articles = [
    { id: 1, title: 'Judul Artikel 1', content: 'Isi artikel 1' },
    { id: 2, title: 'Judul Artikel 2', content: 'Isi artikel 2' },
    { id: 3, title: 'Judul Artikel 3', content: 'Isi artikel 3' },
];
function ArticleDetail() {
  const { id } = useParams();
  const article = articles.find(article => article.id === parseInt(id));
    
  if(!article){
      return <p>Artikel Tidak Ditemukan</p>
  }
  
  return (
    <div>
      <h1>{article.title}</h1>
      <p>{article.content}</p>
    </div>
  );
}

export default ArticleDetail;