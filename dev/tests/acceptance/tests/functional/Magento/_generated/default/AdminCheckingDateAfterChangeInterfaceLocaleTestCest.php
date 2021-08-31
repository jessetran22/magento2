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
 * @Title("MC-17761: Checking date format in orders grid column after changing admin interface locale")
 * @Description("Checking date format in orders grid column after changing admin interface locale<h3>Test files</h3>app/code/Magento/Sales/Test/Mftf/Test/AdminCheckingDateAfterChangeInterfaceLocaleTest.xml<br>")
 * @TestCaseId("MC-17761")
 * @group backend
 * @group ui
 * @group sales
 */
class AdminCheckingDateAfterChangeInterfaceLocaleTestCest
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
		$I->comment("Deploy static content with French locale");
		$deployStaticContentWithFrenchLocale = $I->magentoCLI("setup:static-content:deploy fr_FR", 60); // stepKey: deployStaticContentWithFrenchLocale
		$I->comment($deployStaticContentWithFrenchLocale);
		$I->comment("Create entities");
		$I->createEntity("createProduct", "hook", "SimpleProduct2", [], []); // stepKey: createProduct
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: createCustomer
		$I->comment("Login to Admin page");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete entities");
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->comment("Set Admin \"Interface Locale\" to default value");
		$I->comment("Entering Action Group [setAdminInterfaceLocaleToDefaultValue] SetAdminAccountActionGroup");
		$I->comment("Navigate to admin System Account Page");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_account/index/"); // stepKey: openAdminSystemAccountPageSetAdminInterfaceLocaleToDefaultValue
		$I->waitForElementVisible("#interface_locale", 30); // stepKey: waitForInterfaceLocaleSetAdminInterfaceLocaleToDefaultValue
		$I->comment("Change Admin locale to Français (France) / French (France)");
		$I->selectOption("#interface_locale", "en_US"); // stepKey: setInterfaceLocateSetAdminInterfaceLocaleToDefaultValue
		$I->fillField("#current_password", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordSetAdminInterfaceLocaleToDefaultValue
		$I->click("#save"); // stepKey: clickSaveSetAdminInterfaceLocaleToDefaultValue
		$I->waitForPageLoad(30); // stepKey: clickSaveSetAdminInterfaceLocaleToDefaultValueWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitSuccessMessageSetAdminInterfaceLocaleToDefaultValue
		$I->see("You saved the account.", "#messages div.message-success"); // stepKey: seeSuccessMessageSetAdminInterfaceLocaleToDefaultValue
		$I->comment("Exiting Action Group [setAdminInterfaceLocaleToDefaultValue] SetAdminAccountActionGroup");
		$I->comment("Clear filters");
		$I->comment("Entering Action Group [clearOrderFilters] AdminOrdersGridClearFiltersActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: goToGridOrdersPageClearOrderFilters
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadClearOrderFilters
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header .admin__data-grid-filters-current._show", true); // stepKey: clickOnButtonToRemoveFiltersIfPresentClearOrderFilters
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitAfterClearFiltersClearOrderFilters
		$I->comment("Exiting Action Group [clearOrderFilters] AdminOrdersGridClearFiltersActionGroup");
		$I->comment("Logout from Admin page");
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
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
	 * @Stories({"Checking the value in a grid column"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCheckingDateAfterChangeInterfaceLocaleTest(AcceptanceTester $I)
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
		$grabOrderId = $I->grabTextFrom("|Order # (\d+)|"); // stepKey: grabOrderId
		$I->comment("Filter orders grid by ID on Admin page");
		$I->comment("Entering Action Group [filterOrderGridById] FilterOrderGridByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderGridPageFilterOrderGridById
		$I->waitForPageLoad(30); // stepKey: waitForOrdersPageFilterOrderGridById
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersFilterOrderGridById
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersFilterOrderGridByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClearFiltersFilterOrderGridById
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openOrderGridFiltersFilterOrderGridById
		$I->waitForPageLoad(30); // stepKey: openOrderGridFiltersFilterOrderGridByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClickFiltersFilterOrderGridById
		$I->fillField(".admin__data-grid-filters input[name='increment_id']", $grabOrderId); // stepKey: fillOrderIdFilterFilterOrderGridById
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersFilterOrderGridById
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersFilterOrderGridByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForApplyFiltersFilterOrderGridById
		$I->comment("Exiting Action Group [filterOrderGridById] FilterOrderGridByIdActionGroup");
		$I->comment("Get date from \"Purchase Date\" column");
		$grabPurchaseDateInDefaultLocale = $I->grabTextFrom("//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[contains(., 'Purchase Date')]/preceding-sibling::th) +1 ]"); // stepKey: grabPurchaseDateInDefaultLocale
		$I->comment("Get month name in default locale (US)");
		$getMonthNameInUS = $I->executeJS("return (new Date('{$grabPurchaseDateInDefaultLocale}').toLocaleDateString('en-US', {month: 'short'}))"); // stepKey: getMonthNameInUS
		$I->comment("Checking Date with default \"Interface Locale\"");
		$I->assertStringContainsString($getMonthNameInUS, $grabPurchaseDateInDefaultLocale); // stepKey: checkingDateWithDefaultInterfaceLocale
		$I->comment("Set Admin \"Interface Locale\" to \"Français (France) / français (France)\"");
		$I->comment("Entering Action Group [setAdminInterfaceLocaleToFrance] SetAdminAccountActionGroup");
		$I->comment("Navigate to admin System Account Page");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_account/index/"); // stepKey: openAdminSystemAccountPageSetAdminInterfaceLocaleToFrance
		$I->waitForElementVisible("#interface_locale", 30); // stepKey: waitForInterfaceLocaleSetAdminInterfaceLocaleToFrance
		$I->comment("Change Admin locale to Français (France) / French (France)");
		$I->selectOption("#interface_locale", "fr_FR"); // stepKey: setInterfaceLocateSetAdminInterfaceLocaleToFrance
		$I->fillField("#current_password", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordSetAdminInterfaceLocaleToFrance
		$I->click("#save"); // stepKey: clickSaveSetAdminInterfaceLocaleToFrance
		$I->waitForPageLoad(30); // stepKey: clickSaveSetAdminInterfaceLocaleToFranceWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitSuccessMessageSetAdminInterfaceLocaleToFrance
		$I->see("You saved the account.", "#messages div.message-success"); // stepKey: seeSuccessMessageSetAdminInterfaceLocaleToFrance
		$I->comment("Exiting Action Group [setAdminInterfaceLocaleToFrance] SetAdminAccountActionGroup");
		$I->comment("Filter orders grid by ID on Admin page after changing \"Interface Locale\"");
		$I->comment("Entering Action Group [filterOrderGridByIdAfterSetFrenchLocale] FilterOrderGridByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderGridPageFilterOrderGridByIdAfterSetFrenchLocale
		$I->waitForPageLoad(30); // stepKey: waitForOrdersPageFilterOrderGridByIdAfterSetFrenchLocale
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersFilterOrderGridByIdAfterSetFrenchLocale
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersFilterOrderGridByIdAfterSetFrenchLocaleWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClearFiltersFilterOrderGridByIdAfterSetFrenchLocale
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openOrderGridFiltersFilterOrderGridByIdAfterSetFrenchLocale
		$I->waitForPageLoad(30); // stepKey: openOrderGridFiltersFilterOrderGridByIdAfterSetFrenchLocaleWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClickFiltersFilterOrderGridByIdAfterSetFrenchLocale
		$I->fillField(".admin__data-grid-filters input[name='increment_id']", $grabOrderId); // stepKey: fillOrderIdFilterFilterOrderGridByIdAfterSetFrenchLocale
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersFilterOrderGridByIdAfterSetFrenchLocale
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersFilterOrderGridByIdAfterSetFrenchLocaleWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForApplyFiltersFilterOrderGridByIdAfterSetFrenchLocale
		$I->comment("Exiting Action Group [filterOrderGridByIdAfterSetFrenchLocale] FilterOrderGridByIdActionGroup");
		$I->comment("Get date from \"Purchase Date\" column after changing \"Interface Locale\"");
		$grabPurchaseDateInFrenchLocale = $I->grabTextFrom("//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[contains(., 'Purchase Date')]/preceding-sibling::th) +1 ]"); // stepKey: grabPurchaseDateInFrenchLocale
		$I->comment("Get month name in French");
		$getMonthNameInFrench = $I->executeJS("return (new Date('{$grabPurchaseDateInDefaultLocale}').toLocaleDateString('fr-FR', {month: 'short'}))"); // stepKey: getMonthNameInFrench
		$I->comment("Checking Date after changing \"Interface Locale\"");
		$I->assertStringContainsString($getMonthNameInFrench, $grabPurchaseDateInFrenchLocale); // stepKey: checkingDateAfterChangeInterfaceLocale
	}
}
