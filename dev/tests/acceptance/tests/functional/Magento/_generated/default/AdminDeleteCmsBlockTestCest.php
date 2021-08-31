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
 * @Title("[NO TESTCASEID]: Admin should be able to delete CMS block from grid")
 * @Description("Admin should be able to delete CMS block from grid<h3>Test files</h3>app/code/Magento/Cms/Test/Mftf/Test/AdminDeleteCmsBlockTest.xml<br>")
 * @group Cms
 */
class AdminDeleteCmsBlockTestCest
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
		$I->createEntity("createCMSBlock", "hook", "_defaultBlock", [], []); // stepKey: createCMSBlock
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
	 * @Features({"Cms"})
	 * @Stories({"CMS Blocks Deleting"})
	 * @Severity(level = SeverityLevel::TRIVIAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminDeleteCmsBlockTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateToCmsBlocksGrid] AdminOpenCmsBlocksGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/block/"); // stepKey: navigateToCMSBlocksGridNavigateToCmsBlocksGrid
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadNavigateToCmsBlocksGrid
		$I->comment("Exiting Action Group [navigateToCmsBlocksGrid] AdminOpenCmsBlocksGridActionGroup");
		$I->comment("Entering Action Group [clearGridSearchFilters] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearGridSearchFilters
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearGridSearchFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clearGridSearchFilters] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [findCreatedCmsBlock] AdminSearchCMSBlockInGridByIdentifierActionGroup");
		$I->click("//button[text()='Filters']"); // stepKey: clickFilterButtonFindCreatedCmsBlock
		$I->fillField("//div[@class='admin__form-field-control']/input[@name='identifier']", $I->retrieveEntityField('createCMSBlock', 'identifier', 'test')); // stepKey: fillIdentifierFieldFindCreatedCmsBlock
		$I->click("//span[text()='Apply Filters']"); // stepKey: clickApplyFiltersButtonFindCreatedCmsBlock
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadingFindCreatedCmsBlock
		$I->comment("Exiting Action Group [findCreatedCmsBlock] AdminSearchCMSBlockInGridByIdentifierActionGroup");
		$I->comment("Entering Action Group [deleteCmsBlockFromGrid] AdminDeleteCMSBlockFromGridActionGroup");
		$I->click("//div[text()='" . $I->retrieveEntityField('createCMSBlock', 'identifier', 'test') . "']//parent::td//following-sibling::td//button[text()='Select']"); // stepKey: clickSelectDeleteCmsBlockFromGrid
		$I->click("//a[@data-action='item-delete']"); // stepKey: clickDeleteDeleteCmsBlockFromGrid
		$I->waitForElementVisible("//button[@data-role='action']//span[text()='OK']", 30); // stepKey: waitForOkButtonToBeVisibleDeleteCmsBlockFromGrid
		$I->waitForPageLoad(60); // stepKey: waitForOkButtonToBeVisibleDeleteCmsBlockFromGridWaitForPageLoad
		$I->click("//button[@data-role='action']//span[text()='OK']"); // stepKey: clickOkButtonDeleteCmsBlockFromGrid
		$I->waitForPageLoad(60); // stepKey: clickOkButtonDeleteCmsBlockFromGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadDeleteCmsBlockFromGrid
		$I->comment("Exiting Action Group [deleteCmsBlockFromGrid] AdminDeleteCMSBlockFromGridActionGroup");
		$I->comment("Entering Action Group [assertSuccessMessage] AssertMessageInAdminPanelActionGroup");
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForMessageVisibleAssertSuccessMessage
		$I->see("You deleted the block.", "#messages div.message-success"); // stepKey: verifyMessageAssertSuccessMessage
		$I->comment("Exiting Action Group [assertSuccessMessage] AssertMessageInAdminPanelActionGroup");
		$I->comment("Entering Action Group [clearGridSearchFiltersAfterBlockDeleting] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearGridSearchFiltersAfterBlockDeleting
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearGridSearchFiltersAfterBlockDeletingWaitForPageLoad
		$I->comment("Exiting Action Group [clearGridSearchFiltersAfterBlockDeleting] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [searchDeletedCmsBlock] AdminSearchCMSBlockInGridByIdentifierActionGroup");
		$I->click("//button[text()='Filters']"); // stepKey: clickFilterButtonSearchDeletedCmsBlock
		$I->fillField("//div[@class='admin__form-field-control']/input[@name='identifier']", $I->retrieveEntityField('createCMSBlock', 'identifier', 'test')); // stepKey: fillIdentifierFieldSearchDeletedCmsBlock
		$I->click("//span[text()='Apply Filters']"); // stepKey: clickApplyFiltersButtonSearchDeletedCmsBlock
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadingSearchDeletedCmsBlock
		$I->comment("Exiting Action Group [searchDeletedCmsBlock] AdminSearchCMSBlockInGridByIdentifierActionGroup");
		$I->comment("Entering Action Group [assertDeletedCMSBlockIsNotInGrid] AssertAdminCMSBlockIsNotInGridActionGroup");
		$I->dontSee($I->retrieveEntityField('createCMSBlock', 'identifier', 'test'), "//table[@data-role='grid']//tr/td"); // stepKey: dontSeeCmsBlockInGridAssertDeletedCMSBlockIsNotInGrid
		$I->comment("Exiting Action Group [assertDeletedCMSBlockIsNotInGrid] AssertAdminCMSBlockIsNotInGridActionGroup");
	}
}
