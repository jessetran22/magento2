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
 * @Title("MC-6317: Check that new URL Key works after updating a product through importing CSV file")
 * @Description("Check that new URL Key works after updating a product through importing CSV file<h3>Test files</h3>app/code/Magento/ImportExport/Test/Mftf/Test/AdminURLKeyWorksWhenUpdatingProductThroughImportingCSVTest.xml<br>")
 * @TestCaseId("MC-6317")
 * @group importExport
 */
class AdminURLKeyWorksWhenUpdatingProductThroughImportingCSVTestCest
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
		$I->comment("Create Product");
		$I->createEntity("createCategory", "hook", "SimpleSubCategory", [], []); // stepKey: createCategory
		$I->createEntity("createProduct", "hook", "SimpleProductBeforeUpdate", ["createCategory"], []); // stepKey: createProduct
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
		$I->comment("Delete created data");
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
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
	 * @Stories({"Import Products"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminURLKeyWorksWhenUpdatingProductThroughImportingCSVTest(AcceptanceTester $I)
	{
		$I->comment("Import product from CSV file");
		$I->comment("Entering Action Group [importProduct] AdminImportProductsActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/import/"); // stepKey: goToImportIndexPageImportProduct
		$I->waitForPageLoad(30); // stepKey: adminImportMainSectionLoadImportProduct
		$I->selectOption("#entity", "Products"); // stepKey: selectProductsOptionImportProduct
		$I->waitForElementVisible("#basic_behavior", 30); // stepKey: waitForImportBehaviorElementVisibleImportProduct
		$I->selectOption("#basic_behavior", "Add/Update"); // stepKey: selectImportBehaviorOptionImportProduct
		$I->selectOption("#basic_behaviorvalidation_strategy", "Stop on Error"); // stepKey: selectValidationStrategyOptionImportProduct
		$I->fillField("#basic_behavior_allowed_error_count", "10"); // stepKey: fillAllowedErrorsCountFieldImportProduct
		$I->attachFile("#import_file", "simpleProductUpdate.csv"); // stepKey: attachFileForImportImportProduct
		$I->click("#upload_button"); // stepKey: clickCheckDataButtonImportProduct
		$I->waitForPageLoad(30); // stepKey: clickCheckDataButtonImportProductWaitForPageLoad
		$I->click("#import_validation_container button"); // stepKey: clickImportButtonImportProduct
		$I->waitForPageLoad(30); // stepKey: clickImportButtonImportProductWaitForPageLoad
		$I->waitForElementVisible("#import_validation_messages .message-notice", 30); // stepKey: waitForNoticeMessageImportProduct
		$I->see("Created: 0, Updated: 1, Deleted: 0", "#import_validation_messages .message-notice"); // stepKey: seeNoticeMessageImportProduct
		$I->see("Import successfully done", "#import_validation_messages .message-success"); // stepKey: seeImportMessageImportProduct
		$I->comment("Exiting Action Group [importProduct] AdminImportProductsActionGroup");
		$I->comment("Assert product's updated url");
		$I->amOnPage("/simpleprod.html"); // stepKey: navigateToProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoad
		$I->seeInCurrentUrl("/simpleprod.html"); // stepKey: seeUpdatedUrl
		$I->see($I->retrieveEntityField('createProduct', 'name', 'test'), ".base"); // stepKey: assertProductName
		$I->comment("Entering Action Group [assertProductSku] StorefrontAssertProductSkuOnProductPageActionGroup");
		$I->see($I->retrieveEntityField('createProduct', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: seeProductSkuAssertProductSku
		$I->comment("Exiting Action Group [assertProductSku] StorefrontAssertProductSkuOnProductPageActionGroup");
	}
}
