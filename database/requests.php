<?php

session_start();

function getAll($string)
{

    require 'connect.php';

    $data = mysqli_query($connect, $string);

    if (mysqli_num_rows($data) > 0) {
        return mysqli_fetch_all($data, MYSQLI_ASSOC);
    } else {
        return false;
    }

}

function getOne($string)
{

    require 'connect.php';

    $data = mysqli_query($connect, $string);

    if (mysqli_num_rows($data) > 0) {
        return mysqli_fetch_assoc($data);
    } else {
        return false;
    }

}

function operation($string)
{

    require 'connect.php';

    return mysqli_query($connect, $string);

}

class ApiProvider
{

    public function getUserById($id)
    {

        return getOne("
        select * from users where user_id = '$id'
      ");

    }

    public function getUserByLogin($login)
    {

        return getOne("
        select * from users where login = '$login'
      ");

    }

    public function auth($login, $password)
    {

        $user = $this->getUserByLogin($login);

        $verify = password_verify($password, $user['password']);

        if ($verify) {

            $_SESSION['user'] = [
                'id' => $user['user_id'],
                'surname' => $user['surname'],
                'name' => $user['name'],
                'patronymic' => $user['patronymic'],
                'email' => $user['email'],
                'phone' => $user['phone'],
                'birth' => $user['date_birth'],
                'login' => $user['login'],
                'role' => $user['role_id']
            ];

            header('Location: ../index.php');

        } else {
            $_SESSION['message'] = 'Ошибка авторизации';
            header('Location: ../auth-page.php');
        }

    }

    public function register($surname, $name, $patronymic, $email, $phone, $birth, $login, $password, $password_confirm)
    {

        $login_isset = $this->getUserByLogin($login);

        if ($login_isset) {
            $_SESSION['message'] = 'Пользователь с таким логином уже зарегистрирован';
            header('Location: ../register-page.php');
        } else {

            if ($password == $password_confirm) {

                $roleId = 1;
                $password = password_hash($password, PASSWORD_DEFAULT);

                $success = operation("
            insert into users values
            (null, '$surname', '$name', '$patronymic', '$email', '$phone', '$birth', '$login', '$password', '$roleId')
          ");

                if ($success) {
                    $_SESSION['message'] = 'Регистрация прошла успешно';
                    header('Location: ../auth-page.php');
                } else {
                    $_SESSION['message'] = 'Произошла ошибка во время регистрации';
                    header('Location: ../register-page.php');
                }

            } else {
                $_SESSION['message'] = 'Пароли не совпадают';
                header('Location: ../register-page.php');
            }

        }

    }

    public function getAllUsers()
    {

        return getAll("
        select u.user_id, u.surname, u.name, u.patronymic, u.email, u.phone, u.login, u.password, r.role from users u 
        left join roles r on r.role_id = u.role_id;
      ");

    }

    public function getAllFlights($status)
    {
        return getAll("
        select f.flight_id, f.scheduled_departure, f.scheduled_arrival, 
        da.airport_name as d_name, da.airport_code as d_code, 
        aa.airport_name as a_name, aa.airport_code as a_code,
        s.status, a.model, f.price, 
        (select count(ticket_id) from tickets t
        left join bookings b on b.book_id = t.book_id
        where b.flight_id = f.flight_id and f.status_id = '3') as sold,
        (select count(book_id) from bookings 
        where flight_id = f.flight_id and f.status_id = '1') as booked 
        from flights f
        left join airports da on da.airport_id = f.departure_airport
        left join airports aa on aa.airport_id = f.arrival_airport
        left join statuses s on s.status_id = f.status_id
        left join aircrafts a on a.aircraft_id = f.aircraft_id
        where s.status like '%$status%'
      ");
    }

    public function getAllFlightsWithDate($status, $start, $end)
    {
        return getAll("
          select f.flight_id, f.scheduled_departure, f.scheduled_arrival, 
          da.airport_name as d_name, da.airport_code as d_code, 
          aa.airport_name as a_name, aa.airport_code as a_code,
          s.status, a.model, f.price, 
          (select count(ticket_id) from tickets t
          left join bookings b on b.book_id = t.book_id
          where b.flight_id = f.flight_id and f.status_id = '3') as sold,
          (select count(book_id) from bookings 
          where flight_id = f.flight_id and f.status_id = '1') as booked 
          from flights f
          left join airports da on da.airport_id = f.departure_airport
          left join airports aa on aa.airport_id = f.arrival_airport
          left join statuses s on s.status_id = f.status_id
          left join aircrafts a on a.aircraft_id = f.aircraft_id
          where s.status like '%$status%' 
          and f.scheduled_arrival between '$start' and '$end'
        ");
    }

    public function getAllRoles()
    {

        return getAll("
        select * from roles
      ");

    }

    public function deleteUser($id)
    {

        $success = operation("
        delete from users where user_id = $id
      ");

        if ($success) {
            $_SESSION['message'] = 'Пользователь успешно удален';
        } else {
            $_SESSION['message'] = 'Ошибка удаления пользователя';
        }

        header('Location: ../admin-users-page.php?page=1');

    }

    public function updateUser($surname, $name, $patronymic, $email, $phone, $login, $password, $role, $user_id)
    {

        $user = $this->getUserById($user_id);

        if ($password != $user['password']) {
            $password = password_hash($password, PASSWORD_DEFAULT);
        }

        $success = operation(" 
        update users set surname = '$surname', 
        name = '$name',
        patronymic = '$patronymic',
        email = '$email',
        phone = '$phone',
        login = '$login',
        password = '$password',
        role_id = '$role'
        where user_id = '$user_id'
      ");

        if ($success) {
            $_SESSION['message'] = 'Изменения успешно сохранены';
        } else {
            $_SESSION['message'] = 'Произошла ошибка';
        }

        header('Location: ../admin-users-page.php');

    }

    public function getAllAirports()
    {
        return getAll("
        select a.airport_id, a.airport_name, c.city, a.airport_code from airports a 
        left join cities c on c.city_id = a.city_id;
      ");
    }

    public function getAllClasses()
    {
        return getAll("
        select * from classes order by class_id desc
      ");
    }

    public function getAllGenders()
    {
        return getAll("
        select * from genders
      ");
    }

    public function getFlight($from, $to, $date, $class)
    {
        return getAll("
        select f.flight_id,f.scheduled_departure, f.scheduled_arrival,
        from_a.airport_name as departure_airport, to_a.airport_name as arrival_airport,
        from_c.city as departure_city, to_c.city as arrival_city,
        from_a.airport_code as departure_code, to_a.airport_code as arrival_code,
        s.status, a.model as aircraft_model, f.price,
        (select count(*) from seats where aircraft_id = f.aircraft_id and class_id = '$class') - (select count(book_id) from bookings where flight_id = f.flight_id and class_id = '$class')
        as seats
        from flights f
        left join airports from_a on from_a.airport_id = f.departure_airport
        left join airports to_a on to_a.airport_id = f.arrival_airport
        left join cities from_c on from_c.city_id = from_a.city_id
        left join cities to_c on to_c.city_id = to_a.city_id
        left join statuses s on s.status_id = f.status_id
        left join aircrafts a on a.aircraft_id = f.aircraft_id
        left join seats st on st.aircraft_id = a.aircraft_id and st.class_id = '$class'
        where from_c.city like '%$from%' and to_c.city like '%$to%' and f.scheduled_departure like '%$date%'
        and f.status_id = '1'
        and ((select count(*) from seats where aircraft_id = f.aircraft_id and class_id = '$class') - (select count(book_id) from bookings where flight_id = f.flight_id and class_id = '$class')) > '0' group by f.flight_id;
        ");

    }

    public function getFromToFlight($from, $to, $there_date, $back_date, $class)
    {

        unset($_SESSION['flights']);
        unset($_SESSION['filtered_flights']);
        unset($_SESSION['value']);

        $there = $this->getFlight($from, $to, $there_date, $class);

        if ($back_date) {

            $back = $this->getFlight($to, $from, $back_date, $class);

            $a = $there >= $back ? $there : $back;

            for ($i = 1; $i <= count($a); $i++) {

                $t = count($there) - $i >= 0 ? count($there) - $i : $t;
                $b = count($back) - $i >= 0 ? count($back) - $i : $b;

                $item = [
                    'there' => $there[$t],
                    'back' => $back[$b]
                ];

                $itemList[] = $item;
            }

            if ($back) {
                $_SESSION['flights'] = $itemList;
                header("Location: ../flights-page.php?page=1&class=$class");
            } else {
                $_SESSION['message'] = 'Рейсы не найдены';
                header('Location: ../index.php');
            }

        } else {

            for ($i = 0; $i < count($there); $i++) {

                $item = [
                    'there' => $there[$i]
                ];

                $itemList[] = $item;
            }

            if ($there) {
                $_SESSION['flights'] = $itemList;
                header("Location: ../flights-page.php?page=1&class=$class");
            } else {
                $_SESSION['message'] = 'Рейсы не найдены';
                header('Location: ../index.php');
            }

        }

    }

    public function checkout($there_id, $array, $phone, $email, $user_id, $class, $price, $back_id)
    {

        $user_id = $user_id == null ? 'null' : $user_id;

        require 'connect.php';

        mysqli_autocommit($connect, FALSE);

        $commit = true;

        foreach ($array as $item) {

            $surname = $item['surname'];
            $name = $item['name'];
            $patronymic = $item['patronymic'];
            $gender = $item['gender'];
            $birth_date = $item['birth_date'];
            $document = $item['document'];
            $seat = $item['seat'] == null ? 'null' : $item['seat'];

            if ($back_id) {

                $back_success = operation("
                    INSERT INTO `bookings` VALUES 
                    (null, '$there_id', '$surname', '$name', '$patronymic', '$gender', '$birth_date', '$document', CURRENT_TIMESTAMP, '$class', '$email', '$phone', $user_id, null, '$price');
                ");

                $there_success = operation("
                    INSERT INTO `bookings` VALUES 
                    (null, '$back_id', '$surname', '$name', '$patronymic', '$gender', '$birth_date', '$document', CURRENT_TIMESTAMP, '$class', '$email', '$phone', $user_id, null, '$price');
                ");

                if (!$there_success || !$back_success) {
                    $commit = false;
                }

            } else {
                $success = operation("
                    INSERT INTO `bookings` VALUES 
                    (null, '$there_id', '$surname', '$name', '$patronymic', '$gender', '$birth_date', '$document', CURRENT_TIMESTAMP, '$class', '$email', '$phone', $user_id, $seat, '$price');
                ");

                if (!$success) {
                    $commit = false;
                }
            }

        }

        if ($commit) {
            mysqli_commit($connect);
        } else {
            mysqli_rollback($connect);
        }

        header("Location: ../checkout-result.php?result=$commit");

    }

    public function getHistoryBookings($user_id, $status)
    {
        return getAll("
        select b.flight_id, 
        from_a.airport_name as from_a, from_a.airport_code as from_n, 
        to_a.airport_name as to_a, to_a.airport_code as to_n,
        b.booking_date, f.scheduled_arrival, 
        c.class, c.class_code, s.status, count(b.flight_id) as count,
        b.total_amount, t.ticket_id from bookings b 
        left join flights f on f.flight_id = b.flight_id
        left join airports from_a on from_a.airport_id = f.departure_airport
        left join airports to_a on to_a.airport_id = f.arrival_airport
        left join tickets t on t.book_id = b.book_id
        left join users u on u.user_id = b.user_id
        left join statuses s on s.status_id = f.status_id
        left join classes c on c.class_id = b.class_id
        where b.user_id = '$user_id' and f.status_id != '1' and s.status like '%$status%'
        group by b.flight_id
        order by b.booking_date desc
      ");
    }

    public function getHistoryBookingsWithDate($user_id, $status, $start, $end)
    {
        return getAll("
          select b.flight_id, 
          from_a.airport_name as from_a, from_a.airport_code as from_n, 
          to_a.airport_name as to_a, to_a.airport_code as to_n,
          b.booking_date, f.scheduled_arrival, 
          c.class, c.class_code, s.status, count(b.flight_id) as count,
          b.total_amount, t.ticket_id from bookings b 
          left join flights f on f.flight_id = b.flight_id
          left join airports from_a on from_a.airport_id = f.departure_airport
          left join airports to_a on to_a.airport_id = f.arrival_airport
          left join tickets t on t.book_id = b.book_id
          left join users u on u.user_id = b.user_id
          left join statuses s on s.status_id = f.status_id
          left join classes c on c.class_id = b.class_id
          where b.user_id = '$user_id' and f.status_id != '1' and s.status like '%$status%'
          and f.scheduled_arrival between '$start' and '$end'
          group by b.flight_id
          order by b.booking_date desc
        ");
    }

    public function getActiveBookings($user_id)
    {
        return getAll("
        select b.book_id, b.flight_id, b.surname, b.name, b.patronymic,
        from_a.airport_code as from_n, to_a.airport_code as to_n,
        f.scheduled_departure, c.class_code, c.class, st.seat_no from bookings b 
        left join flights f on f.flight_id = b.flight_id
        left join airports from_a on from_a.airport_id = f.departure_airport
        left join airports to_a on to_a.airport_id = f.arrival_airport
        left join tickets t on t.book_id = b.book_id
        left join statuses s on s.status_id = f.status_id
        left join classes c on c.class_id = b.class_id
        left join seats st on st.seat_id = b.seat_id
        where b.user_id = '$user_id' and f.status_id = '1';
      ");

    }

    public function cancelBooking($book_id)
    {
        $success = operation("
        delete from bookings where book_id = '$book_id'
      ");

        if ($success) {
            $_SESSION['message'] = 'Бронь отменена';
            header('Location: ../profile-page.php?page=1');
        } else {
            $_SESSION['message'] = 'Произошла ошибка';
            header('Location: ../profile-page.php?page=1');
        }
    }

    public function resetPassword($user_id, $password_old, $password, $password_confirm)
    {

        $user_password = getOne("
        select password from users where user_id = '$user_id'
      ");

        $success = password_verify($password_old, $user_password['password']);

        if ($success) {

            if ($password == $password_confirm) {

                $password = password_hash($password, PASSWORD_DEFAULT);

                $success = operation("
            update users set password = '$password' where user_id = '$user_id'
          ");

                if ($success) {
                    $_SESSION['message'] = 'Пароль успешно изменен';
                    header('Location: ../profile-page.php');
                } else {
                    $_SESSION['message'] = 'Произошла ошибка';
                    header('Location: ../reset-password.php');
                }

            } else {
                $_SESSION['message'] = 'Новые пароли не совпадают';
                header('Location: ../reset-password.php');
            }

        } else {
            $_SESSION['message'] = 'Старый пароль введен неверно';
            header('Location: ../reset-password.php');
        }

    }

    public function updateProfile($surname, $name, $patronymic, $email, $phone, $birth, $login, $user_id)
    {

        $success = operation(" 
        update users set surname = '$surname', 
        name = '$name',
        patronymic = '$patronymic',
        email = '$email',
        phone = '$phone',
        date_birth = '$birth',
        login = '$login'
        where user_id = '$user_id'
      ");

        if ($success) {

            $user = $this->getUserById($_SESSION['user']['id']);

            $_SESSION['user'] = [
                'id' => $user['user_id'],
                'surname' => $user['surname'],
                'name' => $user['name'],
                'patronymic' => $user['patronymic'],
                'email' => $user['email'],
                'phone' => $user['phone'],
                'birth' => $user['date_birth'],
                'login' => $user['login'],
                'role' => $user['role_id']
            ];

            $_SESSION['message'] = 'Изменения успешно сохранены';
            header('Location: ../profile-page.php');
        } else {
            $_SESSION['message'] = 'Произошла ошибка';
            header('Location: ../update-profile-page.php');
        }

    }

    public function updateFlightStatus($id, $status)
    {
        if ($status == 2) {
            require 'connect.php';

            mysqli_autocommit($connect, FALSE);

            $commit = true;

            $success = operation("
                update flights set status_id = '$status' where flight_id = '$id'
            ");

            $success = operation("
                insert into notifications values (null, 'Рейс № $id был отменен', 'Рейс № $id был отменен. Просим вас забронировать билет на другой рейс.', current_timestamp, '$id')
            ");

            if (!$success) {
                $commit = false;
            }

            if ($success) {
                mysqli_commit($connect);
                $_SESSION['message'] = 'Статус рейса успешно изменен';

            } else {
                mysqli_rollback($connect);
                $_SESSION['message'] = 'Ошибка изменения статуса';
            }
        } else {
            $success = operation("
                update flights set status_id = '$status' where flight_id = '$id'
            ");

            if ($success) {
                $_SESSION['message'] = 'Статус рейса успешно изменен';

            } else {
                $_SESSION['message'] = 'Ошибка изменения статуса';
            }
        }

        header('Location: ../admin-flights-page.php?page=1');

    }

    public function getAllAircrafts()
    {
        return getAll("
        select * from aircrafts
      ");
    }

    public function registerFlight($from_date, $to_date, $from_airport, $to_airport, $aircraft_id, $price)
    {
        $success = operation("
        INSERT INTO `flights` VALUES 
        (null ,'$from_date','$to_date','$from_airport','$to_airport','1','$aircraft_id','$price', null, null)
      ");

        if ($success) {
            $_SESSION['message'] = 'Рейс успешно зарегистрирован';

        } else {
            $_SESSION['message'] = 'Ошибка регистарции рейса';
        }

        header('Location: ../admin-flights-page.php?page=1');
    }

    public function getPassFromFlight($flight_id)
    {
        return getAll("
            select b.surname, b.name, b.patronymic, b.contact_email, b.contact_phone, c.class, b.total_amount  from bookings b
            left join classes c on c.class_id = b.class_id
            where b.flight_id = '$flight_id';
        ");
    }

    public function getSumFromFlight($flight_id)
    {
        return getOne("
            select sum(total_amount) as sum from bookings where flight_id = '$flight_id';
        ");
    }

    public function getOneFlight($flight_id)
    {
        return getOne("
            SELECT f.flight_id, f.scheduled_departure, f.scheduled_arrival, 
            da.airport_name as departure_name, f.departure_airport as da_id, 
            aa.airport_name as arrival_name, f.arrival_airport as aa_id,
            a.model, f.aircraft_id as a_id, f.price
            FROM `flights` f
            left join airports da on da.airport_id = f.departure_airport
            left join airports aa on aa.airport_id = f.arrival_airport
            left join aircrafts a on a.aircraft_id = f.aircraft_id
            where f.flight_id = '$flight_id'
        ");
    }

    public function updateFlight($from_date, $to_date, $from_airport, $to_airport, $aircraft_id, $price, $id)
    {

        require 'connect.php';

        mysqli_autocommit($connect, FALSE);

        $commit = true;

        $success = operation("
            update flights set 
                               scheduled_departure = '$from_date',
                               scheduled_arrival = '$to_date',
                               departure_airport = '$from_airport',
                               arrival_airport  = '$to_airport',
                               aircraft_id = '$aircraft_id',
                               price = '$price'
            where flight_id = '$id'
        ");

        $success = operation("
            insert into notifications values (null, 'Произошли изменения в рейсе № $id', 'В рейсе № $id произошли изменения, просим Вас ознакомиться с изменениями в профиле.', current_timestamp, '$id')
        ");

        if (!$success) {
            $commit = false;
        }

        if ($success) {
            mysqli_commit($connect);
            $_SESSION['message'] = 'Изменения применены';

        } else {
            mysqli_rollback($connect);
            $_SESSION['message'] = 'Произошла ошибка';
        }

        header('Location: ../admin-flights-page.php?page=1');

    }

    public function deleteFlight($flight_id)
    {
        $success = operation("
            delete from flights where flight_id = '$flight_id'
        ");

        if ($success) {
            $_SESSION['message'] = 'Рейс удален';

        } else {
            $_SESSION['message'] = 'Произошла ошибка';
        }

        header('Location: ../admin-flights-page.php?page=1');
    }

    public function getNotifications($user_id)
    {
        return getAll("
            select n.notification_id, n.notification_title, n.notification_desc, n.notification_date, n.flight_id from notifications n
            left join bookings b on b.flight_id = n.flight_id
            where n.flight_id in (select flight_id from bookings where user_id = '$user_id')
            and n.notification_date > b.booking_date
            order by n.notification_date desc;
        ");
    }

    public function getSeats($flight_id, $class_id)
    {
        return getAll("
            select s.seat_id, s.seat_no, s.aircraft_id from seats s 
            left join flights f on f.aircraft_id = s.aircraft_id
            left join bookings b on b.flight_id = f.flight_id
            where f.flight_id = '$flight_id' and s.class_id = '$class_id' and s.seat_id not in (select seat_id from bookings where flight_id = '$flight_id' and seat_id is not null) 
            group by s.seat_id;
        ");
    }

    public function getReviews()
    {
        return getAll("
            select * from reviews r 
            left join users u on u.user_id = r.user_id
            order by r.review_date desc;
        ");
    }

    public function getAvgReviews()
    {
        return getOne("
            select round(avg(review_rate),2) as avg from reviews;
        ");
    }

    public function addReview($review_text, $user_id, $star)
    {
        $success = operation("
            insert into reviews values (null, '$review_text', current_timestamp, '$star', '$user_id')
        ");

        if ($success) {
            $_SESSION['message'] = 'Спасибо за отзыв';

        } else {
            $_SESSION['message'] = 'Произошла ошибка';
        }

        header('Location: ../reviews-page.php');
    }

    public function addAppeal($support_text, $user_id)
    {
        $success = operation("
            insert into appeals values (null, '$support_text', current_timestamp, null, null, '$user_id')
        ");

        if ($success) {
            $_SESSION['message'] = 'Ваше обращение передано в тех.поддержку';

        } else {
            $_SESSION['message'] = 'Произошла ошибка';
        }

        header('Location: ../support-page.php');
    }

    public function getAppeals($user_id)
    {
        return getAll("
            select * from appeals a
            left join users u on u.user_id = a.user_id
            where a.user_id = '$user_id'
            order by a.appeal_date desc;
        ");
    }

    public function getAllAppeals()
    {
        return getAll("
            select * from appeals a
            left join users u on u.user_id = a.user_id
            where a.appeal_reply is null
            order by a.appeal_date desc;
        ");
    }

    public function addReplyToAppeal($reply_text, $appeal_id)
    {
        $success = operation("
            update appeals set appeal_reply = '$reply_text', appeal_reply_date = current_timestamp where appeal_id = '$appeal_id'
        ");

        if ($success) {
            $_SESSION['message'] = 'Ответ успешно предоставлен';

        } else {
            $_SESSION['message'] = 'Произошла ошибка';
        }

        header('Location: ../admin-appeals-page.php?page=1');
    }

    public function deleteReview($review_id)
    {
        $success = operation("
            delete from reviews where review_id = '$review_id'
        ");

        if ($success) {
            $_SESSION['message'] = 'Отзыв успешно удален';

        } else {
            $_SESSION['message'] = 'Произошла ошибка';
        }

        header('Location: ../reviews-page.php');
    }

}

$provider = new ApiProvider();

?>