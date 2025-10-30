
USE foodexpress;
INSERT INTO categorias (nombre, slug) VALUES
('Pizzas','pizzas'), ('Empanadas','empanadas'), ('Bebidas','bebidas'), ('Postres','postres');

INSERT INTO productos (categoria_id, nombre, descripcion, precio, imagen, stock) VALUES
(1,'Muzzarella','Clásica con salsa y queso', 6200, '', 40),
(1,'Napolitana','Tomate en rodajas y ajo', 6800, '', 30),
(1,'Fugazzeta','Cebolla y mucho queso', 7200, '', 25),
(1,'Calabresa','Con longaniza calabresa', 7500, '', 20),
(2,'Empanada de Carne','Al horno', 1200, '', 200),
(2,'Empanada J&Q','Jamón y queso', 1100, '', 200),
(2,'Empanada Humita','Choclo cremoso', 1100, '', 180),
(3,'Coca-Cola 500ml','Bebida fría', 1500, '', 80),
(3,'Agua 500ml','Sin gas', 1200, '', 100),
(3,'Cerveza Lata','Rubia', 1900, '', 60),
(4,'Flan Casero','Con dulce de leche', 2500, '', 25),
(4,'Tiramisú','Porción', 3200, '', 20);
