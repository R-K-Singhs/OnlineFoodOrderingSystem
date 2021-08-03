const express = require("express");
const mysql = require("mysql");
const cors = require("cors");
const fs = require("fs");
const bcrypt = require("bcrypt");
var nodemailer = require("nodemailer");
const path = require("path");
const fileUpload = require("express-fileupload");
// const { dirname } = require("path");
// const { query, response } = require("express");
const app = express();
app.use(cors());
app.use(fileUpload());
app.use(express.json());

const db = mysql.createPool({
  user: "root",
  host: "localhost",
  password: "Alka15121998",
  database: "sistec_hostel",
});

app.use(express.static(path.join(__dirname, "/public/")));

const isAdmin = (req, result, next) => {
  db.getConnection((error, conn) => {
    console.log("check admin");
    if (error) {
      // conn.release();
      console.log("check admin Error ", error);
      return result.send("failed");
    } else {
      const adminId = req.params.id;
      conn.query(
        `select * from admin where adminId='${adminId}'`,
        (err, res) => {
          if (err) {
            conn.release();
            console.log("invalied");
            return result.send("failed");
          } else {
            console.log(res);
            if (res.length === 1) {
              conn.release();
              console.log("valied admin");
              req.adminId = adminId;
              next();
            } else {
              conn.release();
              console.log("invalied admin");
              return result.send("failed");
            }
          }
        }
      );
    }
  });
  // next();
};

const isHostel = (req, result, next) => {
  db.getConnection((error, conn) => {
    if (error) {
      conn.release();
      return result.send("failed");
    } else {
      const hostelId = req.params.hostelid;
      conn.query(
        `select * from hostels where hostelId='${hostelId}'`,
        (err, res) => {
          if (err) {
            conn.release();
            console.log("invalied hostel");
            return result.send("failed");
          } else {
            // console.log(res);
            if (res.length === 1) {
              conn.release();
              console.log("valied hostel");
              next();
            } else {
              conn.release();
              console.log("invalied admin");
              return result.send("failed");
            }
          }
        }
      );
    }
  });
  // next();
};

app.get("/hostel/:hostelid/room/allrooms", isHostel, (req, result) => {
  db.getConnection((error, conn) => {
    if (error) {
      conn.release();
      return result.send("failed");
    } else {
      const hostelId = req.params.hostelid;
      console.log(hostelId);
      conn.query(
        `select * from rooms  where hostelId='${hostelId}' ORDER BY floorNumber`,
        (err, res) => {
          if (err) {
            conn.release();
            console.log("invalied");
            return result.send("failed");
          } else {
            // console.log(res);
            if (res.length >= 1) {
              conn.release();
              console.log("done");
              return result.send(res);
            } else {
              conn.release();
              console.log("empty");
              return result.send("empty");
            }
          }
        }
      );
    }
  });
});

app.post("/admin/:id/room/newroom", isAdmin, (req, result) => {
  db.getConnection((error, conn) => {
    if (error) {
      console.log(error);
      conn.release();
      return result.send("failed");
    } else {
      const roomName = req.body.roomName;
      const totalBed = req.body.totalBed;
      const isBathRoom = req.body.isBathRoom;
      const floorNumber = req.body.floorNumber;
      const hostelId = req.body.hostelId;
      let roomId =
        "sistec0187_" +
        Number(new Date()) +
        "_" +
        Math.floor(Math.random() * 100000000 + 1);

      const query = `insert into rooms (roomName,totalBed,isBathRoom,floorNumber,hostelId,roomId) values ('${roomName}','${totalBed}','${isBathRoom}','${floorNumber}','${hostelId}','${roomId}') `;
      conn.query(query, (err, res) => {
        console.log("data read from db");
        if (err) {
          console.log("error : ", err);
          conn.release();
          return result.send("failed");
        } else {
          console.log("done");
          conn.release();
          return result.send("done");
        }
      });
    }
  });
});

app.post("/admin/:id/hostel/updatehostel", isAdmin, (req, result) => {
  db.getConnection((error, conn) => {
    if (error) {
      console.log(error);
      conn.release();
      return result.send("failed");
    } else {
      console.log("request received ");
      const hostelName = req.body.hostelName;
      const hostelFee = req.body.hostelFee;
      const wardenEmail = req.body.wardenEmail;
      const aboutHostel = req.body.aboutHostel;
      const title1 = req.body.title1;
      const discription1 = req.body.discription1;
      const title2 = req.body.title2;
      const discription2 = req.body.discription2;
      const title3 = req.body.title3;
      const discription3 = req.body.discription3;
      const title4 = req.body.title4;
      const discription4 = req.body.discription4;
      const title5 = req.body.title5;
      const discription5 = req.body.discription5;
      const hostelId = req.body.hostelId;
      console.log(hostelId);

      let images;
      if (req.files) {
        console.log("file found");
        images = Object.values(req.files);
      }
      const isImages = [
        req.body.isImg1,
        req.body.isImg2,
        req.body.isImg3,
        req.body.isImg4,
        req.body.isImg5,
      ];

      conn.query(
        `select * from wardens where email='${wardenEmail}'`,
        (err, res) => {
          if (err) {
            console.log("error : ", err);
            conn.release();
            return result.send("invaliedWarden");
          } else {
            if (res.length === 1) {
              const wardenId = res[0].wardenId;
              const wardenName = res[0].name;
              const wardenImage = res[0].image;
              const wardenMobile = res[0].mobile;
              console.log(wardenMobile);
              console.log("warden found ", res);

              let fileIndex = 0;

              let imgDir = isImages.map((value, index) => {
                // console.log(value, index);
                if (value === "true") {
                  // console.log(images[fileIndex]);
                  let imagePath =
                    "hostelImages/" + hostelId + "/" + images[fileIndex].name;

                  images[fileIndex].mv(
                    __dirname + "/public/" + imagePath,
                    (err) => {
                      if (err) {
                        console.log("image didn't updated ", err);
                      } else {
                        console.log("image updated successfully");
                      }
                    }
                  );

                  fileIndex++;
                  return imagePath;
                } else {
                  if (index === 0) {
                    return req.body.image1;
                  } else if (index === 1) {
                    return req.body.image2;
                  } else if (index === 2) {
                    return req.body.image3;
                  } else if (index === 3) {
                    return req.body.image4;
                  } else if (index === 4) {
                    return req.body.image5;
                  }
                }
              });
              console.log(imgDir);
              console.log(wardenMobile);

              const query = `UPDATE hostels SET hostelName='${hostelName}',hostelFee='${hostelFee}',wardenId='${wardenId}',wardenName='${wardenName}',wardenImage='${wardenImage}',wardenMobile='${wardenMobile}',wardenEmail='${wardenEmail}',image1='${imgDir[0]}',image2='${imgDir[1]}',image3='${imgDir[2]}',image4='${imgDir[3]}',image5='${imgDir[4]}',title1='${title1}',title2='${title2}',title3='${title3}',title4='${title4}',title5='${title5}',discription1='${discription1}',discription2='${discription2}',discription3='${discription3}',discription4='${discription4}',discription5='${discription5}',aboutHostel='${aboutHostel}' WHERE hostelId='${hostelId}'`;

              conn.query(query, (err) => {
                if (err) {
                  console.log("Error of db : ", err);
                  conn.release();
                  return result.send("failed");
                } else {
                  console.log("database updated");
                  conn.release();
                  return result.send("done");
                }
              });
            } else {
              conn.release();
              return result.send("invaliedWarden");
            }
          }
        }
      );
    }
  });
});

app.get("/admin/:id/hostels/details", isAdmin, (req, result) => {
  console.log("detected");

  db.getConnection((err, conn) => {
    if (err) {
      return result.status(400);
    } else {
      conn.query("select * from hostels ORDER BY id", (err, res) => {
        if (err) {
          conn.release();
          console.log("failed");
          return result.status("failed");
        } else {
          if (res.length > 0) {
            conn.release();
            return result.send(res);
          } else {
            return result.status("empty");
          }
        }
      });
    }
  });
});

app.post("/admin/:id/hostel/newhostel", isAdmin, (req, result) => {
  db.getConnection((error, conn) => {
    if (error) {
      console.log(error);
      // conn.release();
      return result.send("failed");
    } else {
      const hostelName = req.body.hostelName;
      const hostelFee = req.body.hostelFee;
      const wardenEmail = req.body.wardenEmail;
      const aboutHostel = req.body.aboutHostel;
      const title1 = req.body.title1;
      const discription1 = req.body.discription1;
      const title2 = req.body.title2;
      const discription2 = req.body.discription2;
      const title3 = req.body.title3;
      const discription3 = req.body.discription3;
      const title4 = req.body.title4;
      const discription4 = req.body.discription4;
      const title5 = req.body.title5;
      const discription5 = req.body.discription5;
      const adminId = req.adminId;
      let hostelId =
        "sistec0187_" +
        Number(new Date()) +
        "_" +
        Math.floor(Math.random() * 100000000 + 1);
      const images = [
        req.files.image1,
        req.files.image2,
        req.files.image3,
        req.files.image4,
        req.files.image5,
      ];

      conn.query(
        `select * from wardens where email='${wardenEmail}'`,
        (err, res) => {
          console.log("data read from db");
          if (err) {
            console.log("error : ", err);
            conn.release();
            return result.send("invaliedWarden");
          } else {
            if (res.length === 1) {
              const wardenId = res[0].wardenId;
              const wardenName = res[0].name;
              const wardenImage = res[0].image;
              const wardenMobile = res[0].mobile;

              console.log("warden found");
              fs.mkdir(
                __dirname + "/public/hostelImages/" + hostelId,
                (err) => {
                  console.log("file created");
                  if (err) {
                    conn.release();
                    console.log("failed 1", err);
                    return result.send("failed");
                  } else {
                    var imgPaths = images.map((value, index) => {
                      let imageDir =
                        __dirname +
                        "/public/hostelImages/" +
                        hostelId +
                        "/" +
                        value.name;
                      value.mv(imageDir, (err) => {
                        if (err) {
                          console.log("error during");
                          return result.send("failed");
                        }
                      });
                      return "hostelImages/" + hostelId + "/" + value.name;
                    });

                    const query = `insert into hostels (hostelName,hostelId,hostelFee,adminId,wardenId,wardenName,wardenImage,wardenMobile,wardenEmail,image1,image2,image3,image4,image5,title1,title2,title3,title4,title5,discription1,discription2,discription3,discription4,discription5,aboutHostel) values('${hostelName}','${hostelId}','${hostelFee}','${adminId}','${wardenId}','${wardenName}','${wardenImage}','${wardenMobile}','${wardenEmail}','${imgPaths[0]}','${imgPaths[1]}','${imgPaths[2]}','${imgPaths[3]}','${imgPaths[4]}','${title1}','${title2}','${title3}','${title4}','${title5}','${discription1}','${discription2}','${discription3}','${discription4}','${discription5}','${aboutHostel}')`;

                    conn.query(query, (err) => {
                      if (err) {
                        console.log("Error of db : ", err);
                        conn.release();
                        return result.send("failed");
                      } else {
                        console.log("done");
                        conn.release();
                        return result.send("done");
                      }
                    });
                  }
                }
              );
            } else {
              console.log("data not found");
              conn.release();
              return result.send("invaliedWarden");
            }
          }
        }
      );
    }
  });
});

app.post("/student/login", (req, result) => {
  db.getConnection((err, conn) => {
    if (err) {
      return result.send("failed");
    }
    let password = req.body.password;
    let enroll = req.body.enroll;
    const query = `select * from students where enroll= '${enroll}' `;
    conn.query(query, (err, res) => {
      if (err) {
        conn.release();
        return result.send("connection error:" + err);
      } else if (res.length === 1) {
        hashPass = res[0].password;
        bcrypt.compare(password, hashPass).then((isCorrect) => {
          if (isCorrect) {
            conn.release();
            result.send(res);
          } else {
            conn.release();
            result.send("incorrectPass");
          }
        });
      } else {
        conn.release();
        return result.send("notExist");
      }
    });
  });
});

app.post("/hostel/room/students/details", (req, result) => {
  console.log("room parteners ", req.body);

  db.getConnection((error, conn) => {
    if (error) {
      return result.send("failed");
    }

    conn.query(req.body.query, (err, res) => {
      if (err) {
        console.log(err);
        conn.release();
        return result.send("failed");
      }
      conn.release();
      console.log(res);
      result.send(res);
    });
  });
});

app.post("/uploadfile/node/mailer", (req, res) => {
  console.log(req.body.name);
  res.send("done");

  var transporter = nodemailer.createTransport({
    service: "gmail",
    auth: {
      user: "rahulsinghss15121998@gmail.com",
      pass: "Alka@15121998",
    },
  });

  var mailOptions = {
    from: "rahulsinghss15121998@gmail.com",
    to: "rahulsinghss15121998@gmail.com",
    subject: "OTP for email varification",
    html: "<h1>Sistec-Hostel</h1><p>This OTP: <b>0187</b> is for creating your account to <b>Sistec-hostel</b> and this OTP is valied for 10 minuts</p>",
  };

  transporter.sendMail(mailOptions, function (error, info) {
    if (error) {
      console.log("Error" + error);
    } else {
      console.log("Email sent: " + info.response);
    }
  });
});

app.post("/student/room/update_status", (req, response) => {
  db.getConnection((err, conn) => {
    console.log(req.body.query);
    if (err) {
      return response.send(failed);
    }
    conn.query(req.body.query, (err, result) => {
      if (err) {
        conn.release();
        response.send("err");
        console.log("error occured", err);
      } else {
        conn.release();
        // console.log(result);
        response.send("result");
        console.log("done");
      }
    });
  });
});

app.post("/student/signup", (req, response) => {
  console.log("Request: Student SignUp");
  if (
    !req.files ||
    Object.keys(req.files).length === 0 ||
    Object.keys(req.body).length !== 10
  ) {
    return response.send("failed");
  } else {
    db.getConnection((err, connection) => {
      if (err) {
        console.log("database connection error : " + err);
        return response.send("failed");
      } else {
        console.log("connection done");
        let image = req.files.image;
        let name = req.body.name;
        let enroll = req.body.enroll;
        let mobile = req.body.mobile;
        let email = req.body.email;
        let dob = req.body.dob;
        let profile = req.body.profile;
        let session = req.body.session;
        let isdiploma = req.body.isdiploma === "true" ? 1 : 0;
        let password = req.body.password;
        let gender = req.body.gender;
        let studentId = enroll + Math.floor(Math.random() * 1000000 + 1);

        if (
          fs.existsSync(__dirname + "/public/student_profile_images/" + enroll)
        ) {
          console.log("duplicate user");
          connection.release();
          return response.send("DuplicateUser");
        } else {
          fs.mkdir(
            __dirname + "/public/student_profile_images/" + studentId,
            (err) => {
              if (err) throw err;
              let proimgdir =
                __dirname +
                "/public/student_profile_images/" +
                studentId +
                "/" +
                image.name;

              bcrypt.hash(password, 12, (err, res) => {
                if (!err) {
                  password = res;
                  image.mv(proimgdir, function (err) {
                    if (err) {
                      connection.release();
                      return response.send("failed");
                    } else {
                      console.log("image uploaded");
                      console.log(new Date());
                      let query = `INSERT INTO students (name, mobile, password, dob, email,enroll, signUpDate, profile, image,isdiploma,session,gender,studentId) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?);`;
                      connection.query(
                        query,
                        [
                          name,
                          mobile,
                          password,
                          dob,
                          email,
                          enroll,
                          new Date(),
                          profile,
                          "student_profile_images/" +
                            studentId +
                            "/" +
                            image.name,
                          isdiploma,
                          session,
                          gender,
                          studentId,
                        ],
                        (err, res) => {
                          if (err) {
                            if (err.errno === 1062) {
                              console.log("duplicate user");
                              fs.unlink(proimgdir, (err) => {
                                console.log("created file deleted-1");
                                fs.rmdirSync(
                                  __dirname +
                                    "/public/student_profile_images/" +
                                    studentId
                                );
                              });
                              connection.release();
                              return response.send("DuplicateUser");
                            } else {
                              console.log("other error");

                              fs.unlink(proimgdir, (err) => {
                                console.log("created file deleted-2");
                                fs.rmdirSync(
                                  __dirname +
                                    "/public/student_profile_images/" +
                                    studentId
                                );
                              });
                              connection.release();
                              return response.send("failed");
                            }
                          } else {
                            console.log(err);
                            connection.release();
                            return response.send("done");
                          }
                        }
                      );
                    }
                  });
                } else {
                  connection.release();
                  return response.send("failed");
                }
              });
            }
          );
        }
      }
    });
  }
});

app.post("/student/details/id", (req, result) => {
  if (Object.keys(req.body).length === 0) {
    return result.send("failed");
  }
  db.getConnection((error, conn) => {
    if (error) {
      return result.send("failed");
    }
    let query = `select * from students where studentId= '${req.body.studentId}'`;

    conn.query(query, (err, res) => {
      if (err) {
        console.log(err);
        conn.release();
        return result.send("failed");
      }
      conn.release();
      result.send(res);
    });
  });
});

app.listen(3001, () => {
  console.log("yes,your server is running hello");
});
