-- Active: 1660062822988@@127.0.0.1@3306@monsite

-- CREATE DATABASE monsite;


use monsite;


CREATE TABLE posts (
    id VARCHAR(20) NOT NULL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    content TEXT(650000) NOT NULL,
    createAt DATETIME NOT NULL
);


CREATE TABLE categories (
    id VARCHAR(20) NOT NULL PRIMARY KEY,
    category VARCHAR(255) NOT NULL,
    createAt DATETIME NOT NULL
);

CREATE TABLE post_category (
    post_id VARCHAR(20) NOT NULL,
    category_id VARCHAR(20) NOT NULL,
    PRIMARY KEY(post_id, category_id),
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE ON UPDATE RESTRICT,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE ON UPDATE RESTRICT
);


CREATE TABLE user (
    id VARCHAR(20) NOT NULL PRIMARY KEY UNIQUE,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
);

INSERT INTO `user` (`id`, `username`, `password`) VALUES ('USYvwf1pSad56hsgnqL9bBoB', 'admin123', '$2y$10$loRJZ9ACLL3qZhvt5bdJy.rrfFuCzjYxtep.TD5iroKKqZ64l6qqC');
Z