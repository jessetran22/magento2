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
 * @Title("[NO TESTCASEID]: Admin system index management grid change test")
 * @Description("Verify changes in 'Schedule column' on system index management<h3>Test files</h3>app/code/Magento/Indexer/Test/Mftf/Test/AdminSystemIndexManagementGridChangesTest.xml<br>")
 */
class AdminSystemIndexManagementGridChangesTestCest
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
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->createEntity("createProduct", "hook", "_defaultProduct", ["createCategory"], []); // stepKey: createProduct
		$I->comment("Open Index Management Page and Select Index mode \"Update by Schedule\"");
		$setIndexerModeSchedule = $I->magentoCLI("indexer:set-mode", 60, "schedule"); // stepKey: setIndexerModeSchedule
		$I->comment($setIndexerModeSchedule);
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$I->comment("Entering Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [LoginAsAdmin] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$setIndexerModeRealTime = $I->magentoCLI("indexer:set-mode", 60, "realtime"); // stepKey: setIndexerModeRealTime
		$I->comment($setIndexerModeRealTime);
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
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
	 * @Features({"Indexer"})
	 * @Stories({"Menu Navigation"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminSystemIndexManagementGridChangesTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateToIndexManagementPageFirst] AdminNavigateMenuActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitPageLoadNavigateToIndexManagementPageFirst
		$I->click("li[data-ui-id='menu-magento-backend-system']"); // stepKey: clickOnMenuItemNavigateToIndexManagementPageFirst
		$I->waitForPageLoad(30); // stepKey: clickOnMenuItemNavigateToIndexManagementPageFirstWaitForPageLoad
		$I->click("li[data-ui-id='menu-magento-indexer-system-index']"); // stepKey: clickOnSubmenuItemNavigateToIndexManagementPageFirst
		$I->waitForPageLoad(30); // stepKey: clickOnSubmenuItemNavigateToIndexManagementPageFirstWaitForPageLoad
		$I->comment("Exiting Action Group [navigateToIndexManagementPageFirst] AdminNavigateMenuActionGroup");
		$gradScheduleStatusBeforeChange = $I->grabTextFrom("//tr[contains(.,'Product Price')]//td[contains(@class,'col-indexer_schedule_status')]"); // stepKey: gradScheduleStatusBeforeChange
		$I->comment("Verify 'Schedule status' column is present");
		$I->seeElement("//th[contains(@class, 'col-indexer_schedule_status')]"); // stepKey: seeScheduleStatusColumn
		$I->comment("Adding Special price to product");
		$I->comment("Entering Action Group [openAdminProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createProduct', 'id', 'test')); // stepKey: goToProductOpenAdminProductEditPage
		$I->comment("Exiting Action Group [openAdminProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->comment("Entering Action Group [addSpecialPrice] AddSpecialPriceToProductActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddSpecialPrice
		$I->click("button[data-index='advanced_pricing_button']"); // stepKey: clickAdvancedPricingLinkAddSpecialPrice
		$I->waitForPageLoad(30); // stepKey: clickAdvancedPricingLinkAddSpecialPriceWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAdvancedPricingModalAddSpecialPrice
		$I->waitForElementVisible("input[name='product[special_price]']", 30); // stepKey: waitSpecialPriceAddSpecialPrice
		$I->fillField("input[name='product[special_price]']", "8"); // stepKey: fillSpecialPriceAddSpecialPrice
		$I->click(".product_form_product_form_advanced_pricing_modal button.action-primary"); // stepKey: clickDoneAddSpecialPrice
		$I->waitForPageLoad(30); // stepKey: clickDoneAddSpecialPriceWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAdvancedPricingModalGoneAddSpecialPrice
		$I->waitForElementNotVisible("input[name='product[special_price]']", 30); // stepKey: waitForCloseModalWindowAddSpecialPrice
		$I->comment("Exiting Action Group [addSpecialPrice] AddSpecialPriceToProductActionGroup");
		$I->comment("Entering Action Group [saveProductForm] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProductForm
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProductForm
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProductFormWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProductForm
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProductFormWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProductForm
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProductForm
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProductForm
		$I->comment("Exiting Action Group [saveProductForm] SaveProductFormActionGroup");
		$I->comment("Entering Action Group [navigateToIndexManagementPageSecond] AdminNavigateMenuActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitPageLoadNavigateToIndexManagementPageSecond
		$I->click("li[data-ui-id='menu-magento-backend-system']"); // stepKey: clickOnMenuItemNavigateToIndexManagementPageSecond
		$I->waitForPageLoad(30); // stepKey: clickOnMenuItemNavigateToIndexManagementPageSecondWaitForPageLoad
		$I->click("li[data-ui-id='menu-magento-indexer-system-index']"); // stepKey: clickOnSubmenuItemNavigateToIndexManagementPageSecond
		$I->waitForPageLoad(30); // stepKey: clickOnSubmenuItemNavigateToIndexManagementPageSecondWaitForPageLoad
		$I->comment("Exiting Action Group [navigateToIndexManagementPageSecond] AdminNavigateMenuActionGroup");
		$gradScheduleStatusAfterChange = $I->grabTextFrom("//tr[contains(.,'Product Price')]//td[contains(@class,'col-indexer_schedule_status')]"); // stepKey: gradScheduleStatusAfterChange
		$I->comment("Verify 'Schedule Status' column changes for 'Product Price'");
		$I->assertNotEquals("$gradScheduleStatusBeforeChange", "$gradScheduleStatusAfterChange"); // stepKey: assertChange
	}
}
