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
 * @TestCaseId("MC-14657")
 * @Title("MC-14657: Create disabled CMS block entity and assign to category")
 * @Description("Create disabled CMS block entity and assign to category<h3>Test files</h3>app/code/Magento/Cms/Test/Mftf/Test/AdminCreateDisabledCmsBlockEntityAndAssignToCategoryTest.xml<br>")
 * @group cMSContent
 * @group mtf_migrated
 */
class AdminCreateDisabledCmsBlockEntityAndAssignToCategoryTestCest
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
		$I->createEntity("newDefaultCategory", "hook", "_defaultCategory", [], []); // stepKey: newDefaultCategory
		$I->createEntity("newDefaultBlock", "hook", "_defaultBlock", [], []); // stepKey: newDefaultBlock
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
		$I->deleteEntity("newDefaultCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("newDefaultBlock", "hook"); // stepKey: deleteBlock
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
	 * @Stories({"Create a CMS block via the Admin, disable, add to category, verify on frontend"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateDisabledCmsBlockEntityAndAssignToCategoryTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openCmsBlock] AdminOpenCmsBlockActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/block/edit/block_id/" . $I->retrieveEntityField('newDefaultBlock', 'id', 'test')); // stepKey: openEditCmsBlockOpenCmsBlock
		$I->comment("Exiting Action Group [openCmsBlock] AdminOpenCmsBlockActionGroup");
		$I->comment("Entering Action Group [disableBlock] AdminSetCMSBlockDisabledActionGroup");
		$I->seeElement("//input[@name='is_active' and @value='1']"); // stepKey: seeBlockIsEnabledDisableBlock
		$I->click("div[data-index=is_active] .admin__actions-switch-label"); // stepKey: setBlockDisabledDisableBlock
		$I->comment("Exiting Action Group [disableBlock] AdminSetCMSBlockDisabledActionGroup");
		$I->comment("Entering Action Group [saveCMSBlock] SaveCMSBlockActionGroup");
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveButtonSaveCMSBlock
		$I->waitForPageLoad(30); // stepKey: waitForSaveButtonSaveCMSBlockWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveButtonSaveCMSBlock
		$I->waitForPageLoad(30); // stepKey: clickSaveButtonSaveCMSBlockWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSaveCMSBlock
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveCMSBlock
		$I->see("You saved the block."); // stepKey: seeSuccessfulSaveMessageSaveCMSBlock
		$I->comment("Exiting Action Group [saveCMSBlock] SaveCMSBlockActionGroup");
		$I->comment("Entering Action Group [openCategoriesPage] AdminOpenCategoryPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: openAdminCategoryIndexPageOpenCategoriesPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadOpenCategoriesPage
		$I->comment("Exiting Action Group [openCategoriesPage] AdminOpenCategoryPageActionGroup");
		$I->comment("Entering Action Group [expandAll] AdminCategoriesExpandAllActionGroup");
		$I->click(".tree-actions a:last-child"); // stepKey: clickExpandAllExpandAll
		$I->comment("Exiting Action Group [expandAll] AdminCategoriesExpandAllActionGroup");
		$I->comment("Entering Action Group [openCategory] AdminCategoriesOpenCategoryActionGroup");
		$I->click("//a/span[contains(text(), '" . $I->retrieveEntityField('newDefaultCategory', 'name', 'test') . "')]"); // stepKey: clickCategoryLinkOpenCategory
		$I->waitForPageLoad(30); // stepKey: clickCategoryLinkOpenCategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoadOpenCategory
		$I->comment("Exiting Action Group [openCategory] AdminCategoriesOpenCategoryActionGroup");
		$I->comment("Entering Action Group [openContentSection] AdminCategoriesOpenContentSectionActionGroup");
		$I->waitForElementVisible("div[data-index='content']", 30); // stepKey: waitForContentSectionOpenContentSection
		$I->waitForPageLoad(30); // stepKey: waitForContentSectionOpenContentSectionWaitForPageLoad
		$I->conditionalClick("div[data-index='content']", "//*[@class='file-uploader-area']/label[text()='Upload']", false); // stepKey: openContentSectionOpenContentSection
		$I->waitForPageLoad(30); // stepKey: waitForContentSectionLoadOpenContentSection
		$I->comment("Exiting Action Group [openContentSection] AdminCategoriesOpenContentSectionActionGroup");
		$I->comment("Entering Action Group [setStaticBlock] AdminCategoriesSetStaticBlockActionGroup");
		$I->selectOption("//*[@name='landing_page']", "Default Block" . msq("_defaultBlock")); // stepKey: selectBlockSetStaticBlock
		$I->comment("Exiting Action Group [setStaticBlock] AdminCategoriesSetStaticBlockActionGroup");
		$I->comment("Entering Action Group [setDisplay] AdminCategoriesSetDisplayModeActionGroup");
		$I->waitForElementVisible("//*[contains(text(),'Display Settings')]", 30); // stepKey: waitForDisplaySettingsSectionSetDisplay
		$I->waitForPageLoad(30); // stepKey: waitForDisplaySettingsSectionSetDisplayWaitForPageLoad
		$I->conditionalClick("//*[contains(text(),'Display Settings')]", "//*[@name='display_mode']", false); // stepKey: openDisplaySettingsSectionSetDisplay
		$I->waitForPageLoad(30); // stepKey: waitForDisplaySettingsLoadSetDisplay
		$I->selectOption("//*[@name='display_mode']", "Static block only"); // stepKey: selectStaticBlockOnlyOptionSetDisplay
		$I->comment("Exiting Action Group [setDisplay] AdminCategoriesSetDisplayModeActionGroup");
		$I->comment("Entering Action Group [saveCategory] AdminSaveCategoryActionGroup");
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryWithProductsSaveCategory
		$I->waitForPageLoad(30); // stepKey: saveCategoryWithProductsSaveCategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategorySavedSaveCategory
		$I->comment("Exiting Action Group [saveCategory] AdminSaveCategoryActionGroup");
		$I->comment("Entering Action Group [assertSuccessMessage] AssertAdminCategorySaveSuccessMessageActionGroup");
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForElementAssertSuccessMessage
		$I->see("You saved the category.", "#messages div.message-success"); // stepKey: seeSuccessMessageAssertSuccessMessage
		$I->comment("Exiting Action Group [assertSuccessMessage] AssertAdminCategorySaveSuccessMessageActionGroup");
		$I->comment("Entering Action Group [assertBlockOnCategoryFrontPage] AssertStorefrontNoTextOnCategoryPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('newDefaultCategory', 'name', 'test') . ".html"); // stepKey: navigateToCategoryPageAssertBlockOnCategoryFrontPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1AssertBlockOnCategoryFrontPage
		$I->see($I->retrieveEntityField('newDefaultCategory', 'name_lwr', 'test'), "#page-title-heading span"); // stepKey: assertCategoryOnStorefrontAssertBlockOnCategoryFrontPage
		$I->seeInTitle($I->retrieveEntityField('newDefaultCategory', 'name', 'test')); // stepKey: seeCategoryNameInTitleAssertBlockOnCategoryFrontPage
		$I->dontSee("Here is a block test. Yeah!", "#maincontent"); // stepKey: seeAssertTextInMainContentAssertBlockOnCategoryFrontPage
		$I->comment("Exiting Action Group [assertBlockOnCategoryFrontPage] AssertStorefrontNoTextOnCategoryPageActionGroup");
	}
}
