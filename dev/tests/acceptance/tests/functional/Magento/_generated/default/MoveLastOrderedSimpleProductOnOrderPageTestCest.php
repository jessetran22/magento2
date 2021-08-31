<?php
namespace Magento\AcceptanceTest\_default\Backend;

use Magento\FunctionalTestingFramework\AcceptanceTester;
use \Codeception\Util\Locator;
use Yandex\Allure\Adapter\Annotation\Features;
use Yandex\Allure\Adapter\Annotation\Stories;
use Yandex\Allure\Adapter\Annotation\Title;
use Yandex\Allure\Adapter\Annotation\Description;
use Yandex\Allure\Adapter\Annotation\Parameter;
use Yandex\Allure\Adapter\Annotation\Severity;
use Yandex\Allure\Adapter\Model\SeverityLevel;
use Yandex\Allure\Adapter\Annotation\TestCaseId;

/**
 * @Title("MC-16154: Move last ordered simple product on order page test")
 * @Description("Move last ordered simple product on order page<h3>Test files</h3>app/code/Magento/Sales/Test/Mftf/Test/MoveLastOrderedSimpleProductOnOrderPageTest.xml<br>")
 * @TestCaseId("MC-16154")
 * @group sales
 * @group mtf_migrated
 */
class MoveLastOrderedSimpleProductOnOrderPageTestCest
{
    /**
     * @var \Magento\FunctionalTestingFramework\Helper\HelperContainer
     */
    private $helperContainer;

    /**
     * Special method which automatically creates the respective objects.
     */
    public function _inject(\Magento\FunctionalTestingFramework\Helper\HelperContainer $helperContainer)
    {
        $this->helperContainer = $helperContainer;
        $this->helperContainer->create("Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Backend\Test\Mftf\Helper\CurlHelpers");
        $this->helperContainer->create("Magento\Rule\Test\Mftf\Helper\RuleHelper");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Login as admin");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Create customer");
		$I->createEntity("createCustomer", "hook", "Simple_US_CA_Customer", [], []); // stepKey: createCustomer
		$I->comment("Create product");
		$I->createEntity("createProduct", "hook", "SimpleProduct2", [], []); // stepKey: createProduct
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete created data");
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->comment("Entering Action Group [logOut] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogOut
		$I->comment("Exiting Action Group [logOut] AdminLogoutActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _failed(AcceptanceTester $I)
	{
		$I->saveScreenshot(); // stepKey: saveScreenshot
	}

	/**
	 * @Features({"Sales"})
	 * @Stories({"Add Products to Order from Last Ordered Products Section"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function MoveLastOrderedSimpleProductOnOrderPageTest(AcceptanceTester $I)
	{
		$I->comment("Create order");
		$I->comment("Entering Action Group [createOrder] CreateOrderActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order_create/index"); // stepKey: navigateToNewOrderPageCreateOrder
		$I->waitForPageLoad(30); // stepKey: waitForNewOrderPageOpenedCreateOrder
		$I->click("(//td[contains(text(),'" . $I->retrieveEntityField('createCustomer', 'firstname', 'test') . "')])[1]"); // stepKey: chooseCustomerCreateOrder
		$I->waitForPageLoad(60); // stepKey: chooseCustomerCreateOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForStoresPageOpenedCreateOrder
		$I->click("#add_products"); // stepKey: clickOnAddProductsCreateOrder
		$I->waitForPageLoad(60); // stepKey: clickOnAddProductsCreateOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductsListForOrderCreateOrder
		$I->click("//td[contains(text(),'" . $I->retrieveEntityField('createProduct', 'sku', 'test') . "')]"); // stepKey: chooseTheProductCreateOrder
		$I->waitForPageLoad(60); // stepKey: chooseTheProductCreateOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClickProductCreateOrder
		$I->click("#order-search .admin__page-section-title .actions button.action-add"); // stepKey: addSelectedProductToOrderCreateOrder
		$I->waitForPageLoad(30); // stepKey: addSelectedProductToOrderCreateOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductAddedInOrderCreateOrder
		$I->click("//span[text()='Get shipping methods and rates']"); // stepKey: openShippingMethodCreateOrder
		$I->waitForPageLoad(60); // stepKey: openShippingMethodCreateOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForShippingMethodsCreateOrder
		$I->click("//label[contains(text(), 'Fixed')]"); // stepKey: chooseShippingMethodCreateOrder
		$I->waitForPageLoad(60); // stepKey: chooseShippingMethodCreateOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForShippingMethodsThickenedCreateOrder
		$I->click("#submit_order_top_button"); // stepKey: submitOrderCreateOrder
		$I->waitForPageLoad(60); // stepKey: submitOrderCreateOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSubmitOrderCreateOrder
		$I->see("You created the order."); // stepKey: seeSuccessMessageForOrderCreateOrder
		$I->comment("Exiting Action Group [createOrder] CreateOrderActionGroup");
		$I->comment("Search and open customer");
		$I->comment("Entering Action Group [filterCreatedCustomer] AdminFilterCustomerByEmail");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: openCustomerIndexPageFilterCreatedCustomer
		$I->waitForPageLoad(30); // stepKey: waitToCustomerIndexPageToLoadFilterCreatedCustomer
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openFiltersSectionOnCustomerIndexPageFilterCreatedCustomer
		$I->waitForPageLoad(30); // stepKey: openFiltersSectionOnCustomerIndexPageFilterCreatedCustomerWaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: cleanFiltersIfTheySetFilterCreatedCustomer
		$I->waitForPageLoad(30); // stepKey: cleanFiltersIfTheySetFilterCreatedCustomerWaitForPageLoad
		$I->fillField("input[name=email]", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: filterEmailFilterCreatedCustomer
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: applyFilterFilterCreatedCustomer
		$I->waitForPageLoad(30); // stepKey: applyFilterFilterCreatedCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadFilterCreatedCustomer
		$I->comment("Exiting Action Group [filterCreatedCustomer] AdminFilterCustomerByEmail");
		$I->comment("Entering Action Group [clickEditButton] AdminClickFirstRowEditLinkOnCustomerGridActionGroup");
		$I->click("tr[data-repeat-index='0'] .action-menu-item"); // stepKey: clickOnEditLinkClickEditButton
		$I->waitForPageLoad(30); // stepKey: clickOnEditLinkClickEditButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadingClickEditButton
		$I->comment("Exiting Action Group [clickEditButton] AdminClickFirstRowEditLinkOnCustomerGridActionGroup");
		$I->comment("Click create order");
		$I->click("#order"); // stepKey: clickCreateOrder
		$I->waitForPageLoad(30); // stepKey: clickCreateOrderWaitForPageLoad
		$I->comment("Select product in Last Ordered Items section");
		$I->click("//div[@id='sidebar_data_reorder']//tr[td[.='" . $I->retrieveEntityField('createProduct', 'name', 'test') . "']]//input[contains(@name,'add')]"); // stepKey: addProductToOrder
		$I->waitForPageLoad(30); // stepKey: addProductToOrderWaitForPageLoad
		$I->comment("Click Update Changes");
		$I->comment("Entering Action Group [clickUpdateChangesBtn] AdminClickUpdateChangesOnCreateOrderPageActionGroup");
		$I->click(".order-sidebar .actions .action-default.scalable"); // stepKey: clickUpdateChangesBtnClickUpdateChangesBtn
		$I->waitForPageLoad(30); // stepKey: clickUpdateChangesBtnClickUpdateChangesBtnWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForOrderUpdatingClickUpdateChangesBtn
		$I->comment("Exiting Action Group [clickUpdateChangesBtn] AdminClickUpdateChangesOnCreateOrderPageActionGroup");
		$I->comment("Assert product in items ordered grid");
		$I->see($I->retrieveEntityField('createProduct', 'name', 'test'), "//div[contains(@id, 'order-items_grid')]//tbody[1]//td[count(//table[contains(@class, 'order-tables')]//th[contains(., 'Product')]/preceding-sibling::th) +1 ]"); // stepKey: seeProductName
		$I->waitForPageLoad(30); // stepKey: seeProductNameWaitForPageLoad
		$I->see($I->retrieveEntityField('createProduct', 'price', 'test'), "//div[contains(@id, 'order-items_grid')]//tbody[1]//td[count(//table[contains(@class, 'order-tables')]//th[contains(., 'Price')]/preceding-sibling::th) +1 ]"); // stepKey: seeProductPrice
		$I->waitForPageLoad(30); // stepKey: seeProductPriceWaitForPageLoad
	}
}
