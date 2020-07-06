-- 用⼀一条语句句获取平均分⼤大于80分的⽤用户id
select student_id from student_score GROUP BY student_id HAVING AVG(score)>80