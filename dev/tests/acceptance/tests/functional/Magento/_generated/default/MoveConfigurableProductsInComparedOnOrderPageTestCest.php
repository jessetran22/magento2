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
 * @Title("MC-16104: Move configurable products in compared on order page test")
 * @Description("Move configurable products in compared on order page test<h3>Test files</h3>app/code/Magento/Sales/Test/Mftf/Test/MoveConfigurableProductsInComparedOnOrderPageTest.xml<br>")
 * @TestCaseId("MC-16104")
 * @group sales
 * @group mtf_migrated
 */
class MoveConfigurableProductsInComparedOnOrderPageTestCest
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
		$I->comment("Create customer");
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer_CA", [], []); // stepKey: createCustomer
		$I->comment("Create category");
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->comment("Create first configurable product");
		$I->createEntity("createFirstConfigProduct", "hook", "ApiConfigurableProduct", ["createCategory"], []); // stepKey: createFirstConfigProduct
		$I->createEntity("createFirstConfigProductAttribute", "hook", "productAttributeWithTwoOptions", [], []); // stepKey: createFirstConfigProductAttribute
		$I->createEntity("createFirstConfigProductAttributeOption", "hook", "productAttributeOption1", ["createFirstConfigProductAttribute"], []); // stepKey: createFirstConfigProductAttributeOption
		$I->createEntity("createFirstConfigAddToAttributeSet", "hook", "AddToDefaultSet", ["createFirstConfigProductAttribute"], []); // stepKey: createFirstConfigAddToAttributeSet
		$I->getEntity("getFirstConfigAttributeOption", "hook", "ProductAttributeOptionGetter", ["createFirstConfigProductAttribute"], null, 1); // stepKey: getFirstConfigAttributeOption
		$I->createEntity("createFirstConfigChildProduct", "hook", "ApiSimpleOne", ["createFirstConfigProductAttribute", "getFirstConfigAttributeOption", "createCategory"], []); // stepKey: createFirstConfigChildProduct
		$I->createEntity("createFirstConfigProductOption", "hook", "ConfigurableProductTwoOptions", ["createFirstConfigProduct", "createFirstConfigProductAttribute", "getFirstConfigAttributeOption"], []); // stepKey: createFirstConfigProductOption
		$I->createEntity("createFirstConfigProductAddChild", "hook", "ConfigurableProductAddChild", ["createFirstConfigProduct", "createFirstConfigChildProduct"], []); // stepKey: createFirstConfigProductAddChild
		$I->comment("Create second configurable product");
		$I->createEntity("createSecondConfigProduct", "hook", "ApiConfigurableProduct", ["createCategory"], []); // stepKey: createSecondConfigProduct
		$I->createEntity("createSecondConfigProductAttribute", "hook", "productAttributeWithTwoOptions", [], []); // stepKey: createSecondConfigProductAttribute
		$I->createEntity("createSecondConfigProductAttributeOption", "hook", "productAttributeOption1", ["createSecondConfigProductAttribute"], []); // stepKey: createSecondConfigProductAttributeOption
		$I->createEntity("createSecondConfigAddToAttributeSet", "hook", "AddToDefaultSet", ["createSecondConfigProductAttribute"], []); // stepKey: createSecondConfigAddToAttributeSet
		$I->getEntity("getSecondConfigAttributeOption", "hook", "ProductAttributeOptionGetter", ["createSecondConfigProductAttribute"], null, 1); // stepKey: getSecondConfigAttributeOption
		$I->createEntity("createSecondConfigChildProduct", "hook", "ApiSimpleOne", ["createSecondConfigProductAttribute", "getSecondConfigAttributeOption", "createCategory"], []); // stepKey: createSecondConfigChildProduct
		$I->createEntity("createSecondConfigProductOption", "hook", "ConfigurableProductTwoOptions", ["createSecondConfigProduct", "createSecondConfigProductAttribute", "getSecondConfigAttributeOption"], []); // stepKey: createSecondConfigProductOption
		$I->createEntity("createSecondConfigProductAddChild", "hook", "ConfigurableProductAddChild", ["createSecondConfigProduct", "createSecondConfigChildProduct"], []); // stepKey: createSecondConfigProductAddChild
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Admin logout");
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$I->comment("Logout customer");
		$I->comment("Entering Action Group [logoutCustomer] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutLogoutCustomer
		$I->waitForPageLoad(30); // stepKey: waitForSignOutLogoutCustomer
		$I->comment("Exiting Action Group [logoutCustomer] StorefrontCustomerLogoutActionGroup");
		$I->comment("Delete configurable products data");
		$I->deleteEntity("createFirstConfigChildProduct", "hook"); // stepKey: deleteFirstConfigChildProduct
		$I->deleteEntity("createFirstConfigProduct", "hook"); // stepKey: deleteFirstConfigProduct
		$I->deleteEntity("createFirstConfigProductAttribute", "hook"); // stepKey: deleteFirstConfigProductAttribute
		$I->deleteEntity("createSecondConfigChildProduct", "hook"); // stepKey: deleteSecondConfigChildProduct
		$I->deleteEntity("createSecondConfigProduct", "hook"); // stepKey: deleteSecondConfigProduct
		$I->deleteEntity("createSecondConfigProductAttribute", "hook"); // stepKey: deleteSecondConfigProductAttribute
		$I->comment("Delete category");
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Reindex invalidated indices after product attribute has been created/deleted");
		$reindexInvalidatedIndices = $I->magentoCron("index", 90); // stepKey: reindexInvalidatedIndices
		$I->comment($reindexInvalidatedIndices);
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
	 * @Stories({"Add Products to Order from Products in Comparison List Section"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function MoveConfigurableProductsInComparedOnOrderPageTest(AcceptanceTester $I)
	{
		$I->comment("Login as customer");
		$I->comment("Entering Action Group [loginAsCustomer] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLoginAsCustomer
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLoginAsCustomer
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLoginAsCustomer
		$I->fillField("#email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: fillEmailLoginAsCustomer
		$I->fillField("#pass", $I->retrieveEntityField('createCustomer', 'password', 'test')); // stepKey: fillPasswordLoginAsCustomer
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLoginAsCustomer
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLoginAsCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLoginAsCustomer
		$I->comment("Exiting Action Group [loginAsCustomer] LoginToStorefrontActionGroup");
		$I->comment("Add first product to compare list");
		$I->comment("Entering Action Group [openFirstProductPage] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createFirstConfigProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageOpenFirstProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenFirstProductPage
		$I->comment("Exiting Action Group [openFirstProductPage] StorefrontOpenProductPageActionGroup");
		$I->scrollTo("a.action.tocompare"); // stepKey: scrollToCompareProductButton
		$I->comment("Entering Action Group [addFirstProductToCompare] StorefrontAddProductToCompareActionGroup");
		$I->click("a.action.tocompare"); // stepKey: clickAddToCompareAddFirstProductToCompare
		$I->waitForElement("div.message-success.success.message", 30); // stepKey: waitForAddProductToCompareSuccessMessageAddFirstProductToCompare
		$I->see("You added product " . $I->retrieveEntityField('createFirstConfigProduct', 'name', 'test') . " to the comparison list.", "div.message-success.success.message"); // stepKey: assertAddProductToCompareSuccessMessageAddFirstProductToCompare
		$I->comment("Exiting Action Group [addFirstProductToCompare] StorefrontAddProductToCompareActionGroup");
		$I->comment("Add second product to compare list");
		$I->comment("Entering Action Group [openSecondProductPage] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createSecondConfigProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageOpenSecondProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenSecondProductPage
		$I->comment("Exiting Action Group [openSecondProductPage] StorefrontOpenProductPageActionGroup");
		$I->scrollTo("a.action.tocompare"); // stepKey: scrollToCompareProductBtn
		$I->comment("Entering Action Group [addSecondProductToCompare] StorefrontAddProductToCompareActionGroup");
		$I->click("a.action.tocompare"); // stepKey: clickAddToCompareAddSecondProductToCompare
		$I->waitForElement("div.message-success.success.message", 30); // stepKey: waitForAddProductToCompareSuccessMessageAddSecondProductToCompare
		$I->see("You added product " . $I->retrieveEntityField('createSecondConfigProduct', 'name', 'test') . " to the comparison list.", "div.message-success.success.message"); // stepKey: assertAddProductToCompareSuccessMessageAddSecondProductToCompare
		$I->comment("Exiting Action Group [addSecondProductToCompare] StorefrontAddProductToCompareActionGroup");
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
		$I->comment("Entering Action Group [openCustomersGridPage] AdminOpenCustomersGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: openCustomersGridPageOpenCustomersGridPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenCustomersGridPage
		$I->comment("Exiting Action Group [openCustomersGridPage] AdminOpenCustomersGridActionGroup");
		$I->comment("Entering Action Group [openEditCustomerPage] OpenEditCustomerFromAdminActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: navigateToCustomersOpenEditCustomerPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1OpenEditCustomerPage
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersOpenEditCustomerPage
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersOpenEditCustomerPageWaitForPageLoad
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFilterOpenEditCustomerPage
		$I->waitForPageLoad(30); // stepKey: openFilterOpenEditCustomerPageWaitForPageLoad
		$I->fillField("input[name=email]", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: filterEmailOpenEditCustomerPage
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: applyFilterOpenEditCustomerPage
		$I->waitForPageLoad(30); // stepKey: applyFilterOpenEditCustomerPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2OpenEditCustomerPage
		$I->click("tr[data-repeat-index='0'] .action-menu-item"); // stepKey: clickEditOpenEditCustomerPage
		$I->waitForPageLoad(30); // stepKey: clickEditOpenEditCustomerPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3OpenEditCustomerPage
		$I->comment("Exiting Action Group [openEditCustomerPage] OpenEditCustomerFromAdminActionGroup");
		$I->comment("Click 'Create Order'");
		$I->click("#order"); // stepKey: clickCreateOrder
		$I->waitForPageLoad(30); // stepKey: clickCreateOrderWaitForPageLoad
		$I->comment("Add configure to first product");
		$I->click("//div[@id='order-sidebar_compared']//tr[td[contains(.,'" . $I->retrieveEntityField('createFirstConfigProduct', 'name', 'test') . "')]]//a[contains(@class, 'icon-configure')]"); // stepKey: configureFirstProduct
		$I->waitForPageLoad(30); // stepKey: configureFirstProductWaitForPageLoad
		$I->selectOption("//select[contains(concat(' ',normalize-space(@class),' '),' super-attribute-select ')]", $I->retrieveEntityField('getFirstConfigAttributeOption', 'value', 'test')); // stepKey: selectOptionForFirstProduct
		$I->waitForPageLoad(30); // stepKey: selectOptionForFirstProductWaitForPageLoad
		$I->click("//button[contains(concat(' ',normalize-space(@class),' '),' action-primary ')]"); // stepKey: clickOkBtnForFirstProduct
		$I->waitForPageLoad(30); // stepKey: clickOkBtnForFirstProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForConfigureForFirstProductLoad
		$I->comment("Add configure to second product");
		$I->click("//div[@id='order-sidebar_compared']//tr[td[contains(.,'" . $I->retrieveEntityField('createSecondConfigProduct', 'name', 'test') . "')]]//a[contains(@class, 'icon-configure')]"); // stepKey: configureSecondProduct
		$I->waitForPageLoad(30); // stepKey: configureSecondProductWaitForPageLoad
		$I->selectOption("//select[contains(concat(' ',normalize-space(@class),' '),' super-attribute-select ')]", $I->retrieveEntityField('getSecondConfigAttributeOption', 'value', 'test')); // stepKey: selectOptionForSecond
		$I->waitForPageLoad(30); // stepKey: selectOptionForSecondWaitForPageLoad
		$I->click("//button[contains(concat(' ',normalize-space(@class),' '),' action-primary ')]"); // stepKey: clickOkBtnForSecondProduct
		$I->waitForPageLoad(30); // stepKey: clickOkBtnForSecondProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForConfigureForSecondProductLoad
		$I->comment("Click 'Update Changes'");
		$I->comment("Entering Action Group [clickUpdateChangesBtn] AdminClickUpdateChangesOnCreateOrderPageActionGroup");
		$I->click(".order-sidebar .actions .action-default.scalable"); // stepKey: clickUpdateChangesBtnClickUpdateChangesBtn
		$I->waitForPageLoad(30); // stepKey: clickUpdateChangesBtnClickUpdateChangesBtnWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForOrderUpdatingClickUpdateChangesBtn
		$I->comment("Exiting Action Group [clickUpdateChangesBtn] AdminClickUpdateChangesOnCreateOrderPageActionGroup");
		$I->comment("Assert products in items ordered grid");
		$I->see($I->retrieveEntityField('createFirstConfigProduct', 'name', 'test'), "//div[contains(@id, 'order-items_grid')]//tbody[1]//td[count(//table[contains(@class, 'order-tables')]//th[contains(., 'Product')]/preceding-sibling::th) +1 ]"); // stepKey: seeFirstProductName
		$I->waitForPageLoad(30); // stepKey: seeFirstProductNameWaitForPageLoad
		$I->see("$123.00", "//div[contains(@id, 'order-items_grid')]//tbody[1]//td[count(//table[contains(@class, 'order-tables')]//th[contains(., 'Price')]/preceding-sibling::th) +1 ]"); // stepKey: seeFirstProductPrice
		$I->waitForPageLoad(30); // stepKey: seeFirstProductPriceWaitForPageLoad
		$I->see($I->retrieveEntityField('createSecondConfigProduct', 'name', 'test'), "//div[contains(@id, 'order-items_grid')]//tbody[2]//td[count(//table[contains(@class, 'order-tables')]//th[contains(., 'Product')]/preceding-sibling::th) +1 ]"); // stepKey: seeSecondProductName
		$I->waitForPageLoad(30); // stepKey: seeSecondProductNameWaitForPageLoad
		$I->see("$123.00", "//div[contains(@id, 'order-items_grid')]//tbody[2]//td[count(//table[contains(@class, 'order-tables')]//th[contains(., 'Price')]/preceding-sibling::th) +1 ]"); // stepKey: seeSecondProductPrice
		$I->waitForPageLoad(30); // stepKey: seeSecondProductPriceWaitForPageLoad
	}
}
