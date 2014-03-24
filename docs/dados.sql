USE apiteste;

INSERT INTO `perfis`
(`id`,`nome_perfil`)
VALUES
('1','Admin'),
('2','Funcionário');

INSERT INTO `users`
(`id`,`perfis_id`,`username`,`password`)
VALUES
('1', '1', 'admin', 'f1f1f7af46ebdef98111232ed57b18a7bd1590ea');