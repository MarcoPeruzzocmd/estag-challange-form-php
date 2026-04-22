inclusion: manual
Guidelines de Documentação e Comentários de Código
Diretrizes para documentar código de forma eficaz, explicando intenção, decisões e contexto. Aplicável a PHP (PHPDoc), JavaScript/React (JSDoc) e documentação geral do projeto. Obrigatório: deve ser seguido rigorosamente. Recomendado: boas práticas sugeridas, passíveis de exceções justificadas.

Princípio Central
Comente o "por quê", não o "o quê". O código já diz o que faz. Comentários devem explicar por que uma decisão foi tomada, qual o contexto, e quais trade-offs existem.

// ❌ Ruim — reafirma o que o código faz
// Incrementa o contador
$contador++;

// ✅ Bom — explica o motivo
// Conta tentativas para implementar circuit breaker após 3 falhas consecutivas
$contador++;
// ❌ Ruim — óbvio pelo código
// Filtra usuários ativos
const ativos = usuarios.filter(u => u.ativo);

// ✅ Bom — explica contexto de negócio
// Exclui usuários inativos pois não devem receber notificações de cobrança
const ativos = usuarios.filter(u => u.ativo);
Quando Documentar
DOC001 — Toda função/método público deve ter docblock
Severidade: Obrigatório
Por quê: Funções públicas são a interface do módulo. Quem consome precisa entender o contrato sem ler a implementação.
DOC002 — Documentar workarounds e hacks
Severidade: Obrigatório
Por quê: Workarounds sem contexto viram código "intocável" que ninguém ousa alterar.
Incluir: o problema original, por que a solução padrão não funciona, e quando pode ser removido.
/**
 * WORKAROUND: A API do gateway de pagamento retorna 200 mesmo em falhas parciais.
 * Precisamos verificar o campo 'status' no body em vez de confiar no HTTP status.
 * Ticket: PAY-1234
 * Remover quando: gateway atualizar para v3 (previsão Q2 2026)
 */
DOC003 — Documentar algoritmos complexos
Severidade: Obrigatório
Por quê: Lógica não trivial precisa de explicação para manutenção futura.
Incluir: o que o algoritmo faz, complexidade (Big-O), e referências se baseado em paper/artigo.
DOC004 — Documentar decisões de arquitetura
Severidade: Recomendado
Por quê: Preserva conhecimento institucional. Sem isso, decisões são questionadas e refeitas.
Usar ADRs (Architecture Decision Records) ou comentários no código para decisões locais.
DOC005 — Documentar comportamento de erro
Severidade: Obrigatório
Por quê: O consumidor precisa saber quais exceções esperar e como tratá-las.
/**
 * Busca um produto pelo ID.
 *
 * @param int $id ID do produto
 * @return Product Produto encontrado
 * @throws ProductNotFoundException Se o produto não existir
 * @throws DatabaseException Se houver falha na conexão com o banco
 */
public function findById(int $id): Product
DOC006 — Documentar valores de retorno não óbvios
Severidade: Obrigatório
Se uma função retorna null em certos casos, ou um array com estrutura específica, documentar.
Quando NÃO Documentar
DOC007 — Não comentar código óbvio
Severidade: Obrigatório
Por quê: Comentários redundantes são ruído. Poluem o código e ficam desatualizados.
// ❌ Ruim — comentários óbvios
// Define o nome do usuário
const nomeUsuario = "João";
// Retorna o nome
return nomeUsuario;

// ✅ Bom — código autoexplicativo, sem comentários desnecessários
const nomeUsuario = "João";
return nomeUsuario;
DOC008 — Não usar comentários para compensar código ruim
Severidade: Obrigatório
Por quê: Se o código precisa de um parágrafo de explicação, provavelmente precisa ser refatorado.
// ❌ Ruim — comentário compensando código confuso
// Verifica se o usuário tem permissão de admin ou é super-admin
// e se o módulo está ativo e se não está em período de manutenção
if ($u->r === 3 || ($u->r === 5 && $m->a && !$m->mt)) { ... }

// ✅ Bom — código refatorado é autoexplicativo
if ($this->usuarioTemPermissaoAdmin($usuario, $modulo)) { ... }
Formato de Documentação
PHP (PHPDoc)
/**
 * Calcula o desconto aplicável ao pedido baseado nas regras de fidelidade.
 *
 * Clientes com mais de 12 meses recebem 10% de desconto.
 * Clientes com mais de 24 meses recebem 15%.
 * Desconto máximo é limitado a R$500 por pedido.
 *
 * @param Order $pedido Pedido a ser calculado
 * @param Customer $cliente Cliente associado ao pedido
 * @return float Valor do desconto em reais (0.0 se não aplicável)
 * @throws InvalidArgumentException Se o pedido não tiver itens
 */
public function calcularDesconto(Order $pedido, Customer $cliente): float
JavaScript (JSDoc)
/**
 * Formata um valor monetário para exibição no padrão brasileiro.
 *
 * Usa Intl.NumberFormat para garantir formatação consistente
 * independente do locale do navegador.
 *
 * @param {number} valor - Valor em centavos (ex: 1500 = R$15,00)
 * @param {string} [moeda='BRL'] - Código ISO da moeda
 * @returns {string} Valor formatado (ex: "R$ 15,00")
 * @throws {TypeError} Se valor não for um número
 *
 * @example
 * formatarMoeda(1500) // "R$ 15,00"
 * formatarMoeda(1500, 'USD') // "US$ 15.00"
 */
function formatarMoeda(valor, moeda = 'BRL') { ... }
Componentes React
/**
 * Tabela paginada de produtos com busca e ordenação.
 *
 * Busca dados da API automaticamente ao montar.
 * Suporta ordenação por coluna clicando no header.
 * Exibe estados de loading, erro e lista vazia.
 *
 * @param {Object} props
 * @param {string} [props.categoriaId] - Filtra produtos por categoria (opcional)
 * @param {number} [props.itensPorPagina=10] - Quantidade de itens por página
 * @param {Function} props.onSelecionar - Callback ao selecionar um produto
 * @returns {JSX.Element}
 */
function TabelaProdutos({ categoriaId, itensPorPagina = 10, onSelecionar }) { ... }
Documentação de Projeto
DOC009 — README atualizado
Severidade: Obrigatório
Todo projeto/módulo deve ter README com: propósito, como rodar, como testar, e estrutura de pastas.
Atualizar o README no mesmo PR que muda comportamento ou setup.
DOC010 — CHANGELOG para mudanças significativas
Severidade: Recomendado
Manter changelog com breaking changes, features novas e bug fixes relevantes.
DOC011 — Documentar APIs públicas
Severidade: Obrigatório
Endpoints REST devem ter documentação de: URL, método, parâmetros, body esperado, respostas possíveis e códigos de erro.
DOC012 — Marcar código deprecated com prazo
Severidade: Obrigatório
Por quê: Código deprecated sem prazo nunca é removido.
/**
 * @deprecated Desde v2.3. Usar calcularDescontoV2() em vez disso.
 *             Será removido na v3.0 (previsão: Julho 2026).
 * @see calcularDescontoV2()
 */
public function calcularDesconto(Order $pedido): float
/**
 * @deprecated Desde v1.5. Usar useFormatarMoeda() hook em vez disso.
 *             Será removido na v2.0.
 * @see useFormatarMoeda
 */
function formatarPreco(valor) { ... }
Documentação Sincronizada
DOC013 — Docs e código no mesmo PR
Severidade: Obrigatório
Por quê: Documentação desatualizada é pior que nenhuma documentação — engana quem lê.
Se o PR muda uma interface pública, o docblock deve ser atualizado no mesmo PR.
Se o PR muda setup/deploy, o README deve ser atualizado no mesmo PR.
DOC014 — Revisar docs em code review
Severidade: Recomendado
No review, verificar se a documentação reflete o comportamento atual do código.
Perguntar: "Se eu lesse só o docblock, entenderia o contrato dessa função?"
Comentários Inline
DOC015 — TODO/FIXME com contexto
Severidade: Obrigatório
Todo TODO e FIXME deve ter: quem, quando, e ticket/issue associado.
// ❌ Ruim
// TODO: melhorar isso

// ✅ Bom
// TODO(joao, PAY-567): Implementar retry com backoff exponencial.
//   Atualmente falha silenciosamente após timeout do gateway.
//   Prazo: Sprint 15 (Jun 2026)
DOC016 — Comentários de seção para arquivos longos
Severidade: Recomendado
Em arquivos com mais de 100 linhas, usar comentários de seção para separar blocos lógicos.
// ========================================
// Validação de entrada
// ========================================

// ========================================
// Regras de negócio
// ========================================

// ========================================
// Persistência
// ========================================
DOC017 — Explicar regex e queries complexas
Severidade: Obrigatório
Por quê: Regex e SQL complexos são ilegíveis sem contexto.
// Extrai o código do produto no formato "PRD-XXXX-YY" onde X=números, Y=letras
// Exemplo: "PRD-1234-AB" → captura "1234" e "AB"
$pattern = '/^PRD-(\d{4})-([A-Z]{2})$/';
-- Busca pedidos dos últimos 30 dias que tiveram pelo menos 1 item devolvido
-- mas o pedido como um todo NÃO foi cancelado (status != 5)
-- Necessário para o relatório de devoluções parciais (REL-089)
SELECT p.* FROM pedidos p
INNER JOIN pedido_itens pi ON pi.pedido_id = p.id
WHERE pi.devolvido = true
  AND p.status != 5
  AND p.data_criacao >= NOW() - INTERVAL '30 days'
GROUP BY p.id
Checklist de Documentação para Review
Ao revisar um PR, verificar:

[ ] Funções/métodos públicos têm docblock completo
[ ] Workarounds e hacks estão documentados com contexto e prazo
[ ] Algoritmos complexos têm explicação
[ ] Comportamento de erro está documentado (@throws)
[ ] Código deprecated tem @deprecated com alternativa e prazo
[ ] TODOs/FIXMEs têm contexto (quem, ticket, prazo)
[ ] README atualizado se setup/comportamento mudou
[ ] Comentários não reafirmam o óbvio
[ ] Documentação reflete o comportamento atual (não está desatualizada)