CREATE SCHEMA IF NOT EXISTS cart_app;

CREATE TABLE IF NOT EXISTS cart_app."user"
(
    id            SERIAL       NOT NULL,
    name          VARCHAR(100) NOT NULL,
    surname       VARCHAR(150) NOT NULL,
    email         VARCHAR(255)
        CONSTRAINT user_email_key
            UNIQUE             NOT NULL,
    password      VARCHAR(255) NOT NULL,
    api_key       VARCHAR(32)  NOT NULL,
    created       TIMESTAMP WITH TIME ZONE,
    created_by_id INT,
    updated       TIMESTAMP WITH TIME ZONE,
    updated_by_id INT,
    PRIMARY KEY (id),
    FOREIGN KEY (created_by_id) REFERENCES cart_app."user" (id) ON UPDATE CASCADE ON DELETE SET NULL,
    FOREIGN KEY (updated_by_id) REFERENCES cart_app."user" (id) ON UPDATE CASCADE ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS cart_app."offer"
(
    "id"        SERIAL                   NOT NULL,
    "user_id"   SERIAL                   NOT NULL,
    "start"     VARCHAR(255)             NOT NULL,
    "finish"    VARCHAR(255)             NOT NULL,
    "price"     INTEGER                  NOT NULL,
    "space"     INTEGER                  NOT NULL,
    "departure" timestamp with time zone NOT NULL,
    "created"   timestamp with time zone NOT NULL,

    PRIMARY KEY ("id"),
    FOREIGN KEY (user_id) REFERENCES cart_app."user" (id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS cart_app."order"
(
    "id"       SERIAL  NOT NULL,
    "user_id"  SERIAL  NOT NULL,
    "offer_id" SERIAL  NOT NULL,
    "info"     INTEGER NULL,
    "status"   BOOLEAN NOT NULL,

    PRIMARY KEY ("id"),
    FOREIGN KEY (user_id) REFERENCES cart_app."user" (id) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (offer_id) REFERENCES cart_app."offer" (id) ON UPDATE CASCADE ON DELETE CASCADE

);