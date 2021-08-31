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
 * @group reports
 * @Title("[NO TESTCASEID]: The disabled product doesn't present on 'Low Stock' report.")
 * @Description("A product must don't presents on 'Low Stock' report if the product is disabled.<h3>Test files</h3>app/code/Magento/Reports/Test/Mftf/Test/AdminReportsLowStockDisableProductTest.xml<br>")
 */
class AdminReportsLowStockDisableProductTestCest
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
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Created disabled simple product with stock quantity zero");
		$I->createEntity("createProduct", "hook", "SimpleProductDisabledStockQuantityZero", [], []); // stepKey: createProduct
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
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
	 * @Features({"Reports"})
	 * @Stories({"Disabled product doesn't present on 'Low Stock' report"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminReportsLowStockDisableProductTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateToReportsLowStockPage] AdminNavigateMenuActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitPageLoadNavigateToReportsLowStockPage
		$I->click("li[data-ui-id='menu-magento-reports-report']"); // stepKey: clickOnMenuItemNavigateToReportsLowStockPage
		$I->waitForPageLoad(30); // stepKey: clickOnMenuItemNavigateToReportsLowStockPageWaitForPageLoad
		$I->click("li[data-ui-id='menu-magento-reports-report-products-lowstock']"); // stepKey: clickOnSubmenuItemNavigateToReportsLowStockPage
		$I->waitForPageLoad(30); // stepKey: clickOnSubmenuItemNavigateToReportsLowStockPageWaitForPageLoad
		$I->comment("Exiting Action Group [navigateToReportsLowStockPage] AdminNavigateMenuActionGroup");
		$I->comment("Entering Action Group [assertProductInReport] AdminLowStockReportFilterProductActionGroup");
		$I->fillField("#gridLowstock_filter_sku", "testSku" . msq("SimpleProductDisabledStockQuantityZero")); // stepKey: fillSkuFilterFieldAssertProductInReport
		$I->click("//button/span[text()='Search']"); // stepKey: clickSearchAssertProductInReport
		$I->comment("Exiting Action Group [assertProductInReport] AdminLowStockReportFilterProductActionGroup");
		$I->comment("Verify doesn't present in the report");
		$I->dontSeeElement("//tr[1]/td[@data-column='sku']"); // stepKey: assertSelector
	}
}
