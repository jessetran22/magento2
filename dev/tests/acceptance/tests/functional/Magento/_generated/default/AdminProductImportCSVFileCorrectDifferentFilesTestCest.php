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
 * @Description("Product import from CSV file correct from different files.<h3>Test files</h3>app/code/Magento/ImportExport/Test/Mftf/Test/AdminProductImportCSVFileCorrectDifferentFilesTest.xml<br>")
 * @Title("MC-17104: Product import from CSV file correct from different files.")
 * @TestCaseId("MC-17104")
 * @group importExport
 */
class AdminProductImportCSVFileCorrectDifferentFilesTestCest
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
		$I->comment("Login as Admin");
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
		$I->comment("Logout from Admin");
		$I->comment("Entering Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdmin
		$I->comment("Exiting Action Group [logoutFromAdmin] AdminLogoutActionGroup");
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
	 * @Features({"ImportExport"})
	 * @Stories({"Product Import"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminProductImportCSVFileCorrectDifferentFilesTest(AcceptanceTester $I)
	{
		$I->comment("Check data products with add/update behavior");
		$I->comment("Entering Action Group [adminImportProducts] AdminCheckDataForImportProductActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/import/"); // stepKey: goToImportIndexPageAdminImportProducts
		$I->waitForPageLoad(30); // stepKey: adminImportMainSectionLoadAdminImportProducts
		$I->selectOption("#entity", "Products"); // stepKey: selectProductsOptionAdminImportProducts
		$I->waitForElementVisible("#basic_behavior", 30); // stepKey: waitForImportBehaviorElementVisibleAdminImportProducts
		$I->selectOption("#basic_behavior", "Add/Update"); // stepKey: selectImportBehaviorOptionAdminImportProducts
		$I->attachFile("#import_file", "BB-ProductsWorking.csv"); // stepKey: attachFileForImportAdminImportProducts
		$I->click("#upload_button"); // stepKey: clickCheckDataButtonAdminImportProducts
		$I->waitForPageLoad(30); // stepKey: clickCheckDataButtonAdminImportProductsWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearAdminImportProducts
		$I->comment("Exiting Action Group [adminImportProducts] AdminCheckDataForImportProductActionGroup");
		$I->see("File is valid! To start import process press \"Import\" button", ".messages div.message-success"); // stepKey: seeSuccessMessage
		$I->comment("Entering Action Group [adminImportProducts1] AdminCheckDataForImportProductActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/import/"); // stepKey: goToImportIndexPageAdminImportProducts1
		$I->waitForPageLoad(30); // stepKey: adminImportMainSectionLoadAdminImportProducts1
		$I->selectOption("#entity", "Products"); // stepKey: selectProductsOptionAdminImportProducts1
		$I->waitForElementVisible("#basic_behavior", 30); // stepKey: waitForImportBehaviorElementVisibleAdminImportProducts1
		$I->selectOption("#basic_behavior", "Add/Update"); // stepKey: selectImportBehaviorOptionAdminImportProducts1
		$I->attachFile("#import_file", "BB-Products.csv"); // stepKey: attachFileForImportAdminImportProducts1
		$I->click("#upload_button"); // stepKey: clickCheckDataButtonAdminImportProducts1
		$I->waitForPageLoad(30); // stepKey: clickCheckDataButtonAdminImportProducts1WaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearAdminImportProducts1
		$I->comment("Exiting Action Group [adminImportProducts1] AdminCheckDataForImportProductActionGroup");
		$I->see("Curly quotes used instead of straight quotes in row(s): 84, 85", ".messages div.message-error"); // stepKey: seeErrorMessage
	}
}
