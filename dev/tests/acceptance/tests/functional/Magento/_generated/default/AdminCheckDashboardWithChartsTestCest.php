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
 * @Title("MAGETWO-98934: Admin should see Google chart on Magento dashboard")
 * @Description("Google chart on Magento dashboard page is displaying properly<h3>Test files</h3>app/code/Magento/Backend/Test/Mftf/Test/AdminCheckDashboardWithChartsTest.xml<br>")
 * @TestCaseId("MAGETWO-98934")
 * @group backend
 */
class AdminCheckDashboardWithChartsTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$setEnableCharts = $I->magentoCLI("config:set admin/dashboard/enable_charts 1", 60); // stepKey: setEnableCharts
		$I->comment($setEnableCharts);
		$createProductFields['price'] = "150";
		$I->createEntity("createProduct", "hook", "SimpleProduct2", [], $createProductFields); // stepKey: createProduct
		$createCustomerFields['firstname'] = "John1";
		$createCustomerFields['lastname'] = "Doe1";
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer", [], $createCustomerFields); // stepKey: createCustomer
		$I->createEntity("createCustomerCart", "hook", "CustomerCart", ["createCustomer"], []); // stepKey: createCustomerCart
		$I->createEntity("addCartItem", "hook", "CustomerCartItem", ["createCustomerCart", "createProduct"], []); // stepKey: addCartItem
		$I->createEntity("addCustomerOrderAddress", "hook", "CustomerAddressInformation", ["createCustomerCart"], []); // stepKey: addCustomerOrderAddress
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
		$setDisableChartsAsDefault = $I->magentoCLI("config:set admin/dashboard/enable_charts 0", 60); // stepKey: setDisableChartsAsDefault
		$I->comment($setDisableChartsAsDefault);
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
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
	 * @Features({"Backend"})
	 * @Stories({"Google Charts on Magento dashboard"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCheckDashboardWithChartsTest(AcceptanceTester $I)
	{
		$grabQuantityBefore = $I->grabTextFrom("//*[@class='dashboard-totals-label' and contains(text(), 'Quantity')]/../*[@class='dashboard-totals-value']"); // stepKey: grabQuantityBefore
		$I->updateEntity("createCustomerCart", "test", "CustomerOrderPaymentMethod",["createCustomerCart"]); // stepKey: sendCustomerPaymentInformation
		$I->createEntity("invoiceOrder", "test", "Invoice", ["createCustomerCart"], []); // stepKey: invoiceOrder
		$I->createEntity("shipOrder", "test", "Shipment", ["createCustomerCart"], []); // stepKey: shipOrder
		$I->reloadPage(); // stepKey: refreshPage
		$I->comment("Entering Action Group [assertAdminDashboardNotBroken] AssertAdminDashboardDisplayedWithNoErrorsActionGroup");
		$I->seeElement("#diagram_tab_orders_content"); // stepKey: seeOrderContentTabAssertAdminDashboardNotBroken
		$I->seeElement("#diagram_tab_content"); // stepKey: seeDiagramContentAssertAdminDashboardNotBroken
		$I->click("#diagram_tab_amounts"); // stepKey: clickDashboardAmountAssertAdminDashboardNotBroken
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForDashboardAmountLoadingAssertAdminDashboardNotBroken
		$I->seeElement("#diagram_tab_amounts_content"); // stepKey: seeDiagramAmountContentAssertAdminDashboardNotBroken
		$I->seeElement("#diagram_tab_amounts_content"); // stepKey: seeAmountTotalsAssertAdminDashboardNotBroken
		$I->dontSeeJsError(); // stepKey: dontSeeJsErrorAssertAdminDashboardNotBroken
		$I->comment("Exiting Action Group [assertAdminDashboardNotBroken] AssertAdminDashboardDisplayedWithNoErrorsActionGroup");
		$grabQuantityAfter = $I->grabTextFrom("//*[@class='dashboard-totals-label' and contains(text(), 'Quantity')]/../*[@class='dashboard-totals-value']"); // stepKey: grabQuantityAfter
		$I->assertGreaterThan($grabQuantityBefore, $grabQuantityAfter); // stepKey: checkQuantityWasChanged
	}
}
