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
 * @Title("MC-6060: Update category, make inactive")
 * @Description("Login as admin and update category and  make it Inactive<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminUpdateCategoryAndMakeInactiveTest.xml<br>")
 * @TestCaseId("MC-6060")
 * @group Catalog
 * @group mtf_migrated
 */
class AdminUpdateCategoryAndMakeInactiveTestCest
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
		$I->comment("Entering Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginToAdminPanel
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginToAdminPanel
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginToAdminPanel
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginToAdminPanel
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginToAdminPanelWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginToAdminPanel
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginToAdminPanel
		$I->comment("Exiting Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->createEntity("createDefaultCategory", "hook", "_defaultCategory", [], []); // stepKey: createDefaultCategory
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createDefaultCategory", "hook"); // stepKey: deleteCreatedCategory
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
	 * @Stories({"Update categories"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Features({"Catalog"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminUpdateCategoryAndMakeInactiveTest(AcceptanceTester $I)
	{
		$I->comment("Open category page");
		$I->comment("Entering Action Group [openAdminCategoryIndexPage] AdminOpenCategoryPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: openAdminCategoryIndexPageOpenAdminCategoryIndexPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadOpenAdminCategoryIndexPage
		$I->comment("Exiting Action Group [openAdminCategoryIndexPage] AdminOpenCategoryPageActionGroup");
		$I->comment("Update category and make category inactive");
		$I->comment("Entering Action Group [navigateToCreatedCategory] NavigateToCreatedCategoryActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: amOnCategoryPageNavigateToCreatedCategory
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1NavigateToCreatedCategory
		$I->click(".tree-actions a:last-child"); // stepKey: expandAllNavigateToCreatedCategory
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2NavigateToCreatedCategory
		$I->click("//a/span[contains(text(), '" . $I->retrieveEntityField('createDefaultCategory', 'Name', 'test') . "')]"); // stepKey: navigateToCreatedCategoryNavigateToCreatedCategory
		$I->waitForPageLoad(30); // stepKey: navigateToCreatedCategoryNavigateToCreatedCategoryWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSpinnerNavigateToCreatedCategory
		$I->comment("Exiting Action Group [navigateToCreatedCategory] NavigateToCreatedCategoryActionGroup");
		$I->comment("Entering Action Group [disableCategory] AdminDisableActiveCategoryActionGroup");
		$I->click("input[name='is_active']+label"); // stepKey: disableActiveCategoryDisableCategory
		$I->comment("Exiting Action Group [disableCategory] AdminDisableActiveCategoryActionGroup");
		$I->comment("Entering Action Group [clickSaveButton] AdminSaveCategoryActionGroup");
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryWithProductsClickSaveButton
		$I->waitForPageLoad(30); // stepKey: saveCategoryWithProductsClickSaveButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategorySavedClickSaveButton
		$I->comment("Exiting Action Group [clickSaveButton] AdminSaveCategoryActionGroup");
		$I->comment("Entering Action Group [assertSuccessMessage] AssertAdminCategorySaveSuccessMessageActionGroup");
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForElementAssertSuccessMessage
		$I->see("You saved the category.", "#messages div.message-success"); // stepKey: seeSuccessMessageAssertSuccessMessage
		$I->comment("Exiting Action Group [assertSuccessMessage] AssertAdminCategorySaveSuccessMessageActionGroup");
		$I->comment("Entering Action Group [seePageTitle] AssertAdminCategoryPageTitleActionGroup");
		$I->see($I->retrieveEntityField('createDefaultCategory', 'name', 'test'), "h1.page-title"); // stepKey: seeProperPageTitleSeePageTitle
		$I->comment("Exiting Action Group [seePageTitle] AssertAdminCategoryPageTitleActionGroup");
		$I->comment("Entering Action Group [seeDisabledCategory] AssertAdminCategoryIsInactiveActionGroup");
		$I->dontSeeCheckboxIsChecked("input[name='is_active']"); // stepKey: seeCategoryIsDisabledSeeDisabledCategory
		$I->comment("Exiting Action Group [seeDisabledCategory] AssertAdminCategoryIsInactiveActionGroup");
		$I->comment("Verify Inactive Category is store front page");
		$I->comment("Entering Action Group [goToStoreFront] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToStoreFront
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToStoreFront
		$I->comment("Exiting Action Group [goToStoreFront] StorefrontOpenHomePageActionGroup");
		$I->comment("Entering Action Group [doNotSeeCategoryNameInMenu] StorefrontAssertCategoryNameIsNotShownInMenuActionGroup");
		$I->dontSeeElement("//nav//a[span[contains(., '" . $I->retrieveEntityField('createDefaultCategory', 'name', 'test') . "')]]"); // stepKey: doNotSeeCatergoryInStoreFrontDoNotSeeCategoryNameInMenu
		$I->waitForPageLoad(30); // stepKey: doNotSeeCatergoryInStoreFrontDoNotSeeCategoryNameInMenuWaitForPageLoad
		$I->comment("Exiting Action Group [doNotSeeCategoryNameInMenu] StorefrontAssertCategoryNameIsNotShownInMenuActionGroup");
		$I->comment("Verify Inactive Category in category page");
		$I->comment("Entering Action Group [goToAdminCategoryIndexPage] AdminOpenCategoryPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: openAdminCategoryIndexPageGoToAdminCategoryIndexPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadGoToAdminCategoryIndexPage
		$I->comment("Exiting Action Group [goToAdminCategoryIndexPage] AdminOpenCategoryPageActionGroup");
		$I->comment("Entering Action Group [expandCategoryTree] AdminExpandCategoryTreeActionGroup");
		$I->click(".tree-actions a:last-child"); // stepKey: clickOnExpandTreeExpandCategoryTree
		$I->waitForPageLoad(30); // stepKey: waitForCategoryToLoadExpandCategoryTree
		$I->comment("Exiting Action Group [expandCategoryTree] AdminExpandCategoryTreeActionGroup");
		$I->comment("Entering Action Group [seeCategoryInTree] AssertAdminCategoryIsListedInCategoriesTreeActionGroup");
		$I->seeElement("//a/span[contains(text(), '" . $I->retrieveEntityField('createDefaultCategory', 'name', 'test') . "')]"); // stepKey: seeCategoryInTreeSeeCategoryInTree
		$I->waitForPageLoad(30); // stepKey: seeCategoryInTreeSeeCategoryInTreeWaitForPageLoad
		$I->comment("Exiting Action Group [seeCategoryInTree] AssertAdminCategoryIsListedInCategoriesTreeActionGroup");
		$I->comment("Entering Action Group [openCategory] AdminCategoriesOpenCategoryActionGroup");
		$I->click("//a/span[contains(text(), '" . $I->retrieveEntityField('createDefaultCategory', 'name', 'test') . "')]"); // stepKey: clickCategoryLinkOpenCategory
		$I->waitForPageLoad(30); // stepKey: clickCategoryLinkOpenCategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoadOpenCategory
		$I->comment("Exiting Action Group [openCategory] AdminCategoriesOpenCategoryActionGroup");
		$I->comment("Entering Action Group [seeCategoryPageTitle] AssertAdminCategoryPageTitleActionGroup");
		$I->see($I->retrieveEntityField('createDefaultCategory', 'name', 'test'), "h1.page-title"); // stepKey: seeProperPageTitleSeeCategoryPageTitle
		$I->comment("Exiting Action Group [seeCategoryPageTitle] AssertAdminCategoryPageTitleActionGroup");
		$I->comment("Entering Action Group [assertCategoryIsInactive] AssertAdminCategoryIsInactiveActionGroup");
		$I->dontSeeCheckboxIsChecked("input[name='is_active']"); // stepKey: seeCategoryIsDisabledAssertCategoryIsInactive
		$I->comment("Exiting Action Group [assertCategoryIsInactive] AssertAdminCategoryIsInactiveActionGroup");
	}
}
