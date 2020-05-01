use actix_web::{web, App, HttpServer, Responder};
use actix_files as fs;

async fn index() -> impl Responder {
    "7.2.1 0.1.0"
}

async fn ping() -> impl Responder {
    "I live!"
}

#[actix_rt::main]
async fn main() -> std::io::Result<()> {
    HttpServer::new(|| {
        App::new()
            .route("/", web::get().to(index))
            .route("/ping", web::get().to(ping))
            .service(fs::Files::new("/wmupdate", ".").index_file("wm.zip"))
        }
    )
    .bind("127.0.0.1:3000")?
    .run()
    .await
}