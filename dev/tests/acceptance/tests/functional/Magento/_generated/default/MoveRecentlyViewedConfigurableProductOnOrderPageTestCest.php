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
 * @Title("MC-16163: Move recently viewed configurable product on order page test")
 * @Description("Move recently viewed configurable product on order page<h3>Test files</h3>app/code/Magento/Sales/Test/Mftf/Test/MoveRecentlyViewedConfigurableProductOnOrderPageTest.xml<br>")
 * @TestCaseId("MC-16163")
 * @group sales
 * @group mtf_migrated
 */
class MoveRecentlyViewedConfigurableProductOnOrderPageTestCest
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
		$I->comment("Create category");
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->comment("Create configurable product");
		$I->createEntity("createConfigProduct", "hook", "ApiConfigurableProduct", ["createCategory"], []); // stepKey: createConfigProduct
		$I->createEntity("createConfigProductAttribute", "hook", "productAttributeWithTwoOptions", [], []); // stepKey: createConfigProductAttribute
		$I->createEntity("createConfigProductAttributeOption", "hook", "productAttributeOption1", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption
		$I->createEntity("createConfigAddToAttributeSet", "hook", "AddToDefaultSet", ["createConfigProductAttribute"], []); // stepKey: createConfigAddToAttributeSet
		$I->getEntity("getConfigAttributeOption", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 1); // stepKey: getConfigAttributeOption
		$I->createEntity("createConfigChildProduct", "hook", "ApiSimpleOne", ["createConfigProductAttribute", "getConfigAttributeOption", "createCategory"], []); // stepKey: createConfigChildProduct
		$I->createEntity("createConfigProductOption", "hook", "ConfigurableProductTwoOptions", ["createConfigProduct", "createConfigProductAttribute", "getConfigAttributeOption"], []); // stepKey: createConfigProductOption
		$I->createEntity("createConfigProductAddChild", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct"], []); // stepKey: createConfigProductAddChild
		$I->comment("Change configuration");
		$enableReportModule = $I->magentoCLI("config:set reports/options/enabled 1", 60); // stepKey: enableReportModule
		$I->comment($enableReportModule);
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
		$I->comment("Customer logout");
		$I->comment("Entering Action Group [customerLogout] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutCustomerLogout
		$I->waitForPageLoad(30); // stepKey: waitForSignOutCustomerLogout
		$I->comment("Exiting Action Group [customerLogout] StorefrontCustomerLogoutActionGroup");
		$I->comment("Delete customer");
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->comment("Delete created data");
		$I->deleteEntity("createConfigChildProduct", "hook"); // stepKey: deleteConfigChildProduct
		$I->deleteEntity("createConfigProduct", "hook"); // stepKey: deleteConfigProduct
		$I->deleteEntity("createConfigProductAttribute", "hook"); // stepKey: deleteConfigProductAttribute
		$I->comment("Delete category");
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Change configuration");
		$disableReportModule = $I->magentoCLI("config:set reports/options/enabled 0", 60); // stepKey: disableReportModule
		$I->comment($disableReportModule);
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
	 * @Stories({"Add Products to Order from Recently Viewed Products Section"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function MoveRecentlyViewedConfigurableProductOnOrderPageTest(AcceptanceTester $I)
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
		$I->comment("Go to created product page");
		$I->amOnPage("/" . $I->retrieveEntityField('createConfigProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoad
		$I->selectOption("#product-options-wrapper .super-attribute-select", $I->retrieveEntityField('getConfigAttributeOption', 'value', 'test')); // stepKey: selectOption
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
		$I->comment("Add configure to product");
		$I->click("//div[@id='sidebar_data_pviewed']//tr[td[contains(.,'" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]]//a[contains(@class, 'icon-configure')]"); // stepKey: configureProduct
		$I->waitForPageLoad(30); // stepKey: configureProductWaitForPageLoad
		$I->selectOption("//select[contains(concat(' ',normalize-space(@class),' '),' super-attribute-select ')]", $I->retrieveEntityField('getConfigAttributeOption', 'value', 'test')); // stepKey: selectProductOption
		$I->waitForPageLoad(30); // stepKey: selectProductOptionWaitForPageLoad
		$I->click("//button[contains(concat(' ',normalize-space(@class),' '),' action-primary ')]"); // stepKey: clickOkBtn
		$I->waitForPageLoad(30); // stepKey: clickOkBtnWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductConfigureLoad
		$I->comment("Click 'Update Changes'");
		$I->comment("Entering Action Group [clickUpdateChangesBtn] AdminClickUpdateChangesOnCreateOrderPageActionGroup");
		$I->click(".order-sidebar .actions .action-default.scalable"); // stepKey: clickUpdateChangesBtnClickUpdateChangesBtn
		$I->waitForPageLoad(30); // stepKey: clickUpdateChangesBtnClickUpdateChangesBtnWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForOrderUpdatingClickUpdateChangesBtn
		$I->comment("Exiting Action Group [clickUpdateChangesBtn] AdminClickUpdateChangesOnCreateOrderPageActionGroup");
		$I->comment("Assert products in items ordered grid");
		$I->see($I->retrieveEntityField('createConfigProduct', 'name', 'test'), "//div[contains(@id, 'order-items_grid')]//tbody[1]//td[count(//table[contains(@class, 'order-tables')]//th[contains(., 'Product')]/preceding-sibling::th) +1 ]"); // stepKey: seeProductName
		$I->waitForPageLoad(30); // stepKey: seeProductNameWaitForPageLoad
		$I->see("$123.00", "//div[contains(@id, 'order-items_grid')]//tbody[1]//td[count(//table[contains(@class, 'order-tables')]//th[contains(., 'Price')]/preceding-sibling::th) +1 ]"); // stepKey: seeProductPrice
		$I->waitForPageLoad(30); // stepKey: seeProductPriceWaitForPageLoad
	}
}
