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
 * @Title("MC-13635: Active category is visible on navigation menu while subcategory is not visible on navigation menu, Include in Menu = Yes")
 * @Description("Login as admin and verify subcategory is not visible in navigation menu<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminCheckSubCategoryIsNotVisibleInNavigationMenuTest.xml<br>")
 * @TestCaseId("MC-13635")
 * @group mtf_migrated
 */
class AdminCheckSubCategoryIsNotVisibleInNavigationMenuTestCest
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
		$I->comment("Login as Admin");
		$I->comment("Entering Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginToAdminPanel
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginToAdminPanel
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginToAdminPanel
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginToAdminPanel
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginToAdminPanelWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginToAdminPanel
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginToAdminPanel
		$I->comment("Exiting Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->comment("Create Parent Category");
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete created data");
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
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
	 * @Stories({"Create category"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Catalog"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCheckSubCategoryIsNotVisibleInNavigationMenuTest(AcceptanceTester $I)
	{
		$I->comment("Open Category Page");
		$I->comment("Entering Action Group [openAdminCategoryIndexPage] AdminOpenCategoryPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: openAdminCategoryIndexPageOpenAdminCategoryIndexPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadOpenAdminCategoryIndexPage
		$I->comment("Exiting Action Group [openAdminCategoryIndexPage] AdminOpenCategoryPageActionGroup");
		$I->comment("Create subcategory under parent category");
		$I->comment("Entering Action Group [openCreatedCategory] NavigateToCreatedCategoryActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: amOnCategoryPageOpenCreatedCategory
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1OpenCreatedCategory
		$I->click(".tree-actions a:last-child"); // stepKey: expandAllOpenCreatedCategory
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2OpenCreatedCategory
		$I->click("//a/span[contains(text(), '" . $I->retrieveEntityField('createCategory', 'Name', 'test') . "')]"); // stepKey: navigateToCreatedCategoryOpenCreatedCategory
		$I->waitForPageLoad(30); // stepKey: navigateToCreatedCategoryOpenCreatedCategoryWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSpinnerOpenCreatedCategory
		$I->comment("Exiting Action Group [openCreatedCategory] NavigateToCreatedCategoryActionGroup");
		$I->comment("Entering Action Group [createSubcategory] CreateCategoryActionGroup");
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: seeOnCategoryPageCreateSubcategory
		$I->click("#add_subcategory_button"); // stepKey: clickOnAddSubCategoryCreateSubcategory
		$I->waitForPageLoad(30); // stepKey: clickOnAddSubCategoryCreateSubcategoryWaitForPageLoad
		$I->see("New Category", ".page-header h1.page-title"); // stepKey: seeCategoryPageTitleCreateSubcategory
		$I->fillField("input[name='name']", "SimpleSubCategory" . msq("SimpleSubCategory")); // stepKey: enterCategoryNameCreateSubcategory
		$I->click("div[data-index='search_engine_optimization'] .fieldset-wrapper-title"); // stepKey: openSEOCreateSubcategory
		$I->waitForPageLoad(30); // stepKey: openSEOCreateSubcategoryWaitForPageLoad
		$I->fillField("input[name='url_key']", "simplesubcategory" . msq("SimpleSubCategory")); // stepKey: enterURLKeyCreateSubcategory
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryCreateSubcategory
		$I->waitForPageLoad(30); // stepKey: saveCategoryCreateSubcategoryWaitForPageLoad
		$I->seeElement(".message-success"); // stepKey: assertSuccessCreateSubcategory
		$I->seeInTitle("SimpleSubCategory" . msq("SimpleSubCategory")); // stepKey: seeNewCategoryPageTitleCreateSubcategory
		$I->seeElement("//a/span[contains(text(), 'SimpleSubCategory" . msq("SimpleSubCategory") . "')]"); // stepKey: seeCategoryInTreeCreateSubcategory
		$I->waitForPageLoad(30); // stepKey: seeCategoryInTreeCreateSubcategoryWaitForPageLoad
		$I->comment("Exiting Action Group [createSubcategory] CreateCategoryActionGroup");
		$I->comment("Verify Parent Category is visible in navigation menu and Sub category is not visible in navigation menu");
		$I->comment("Entering Action Group [openHomepage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageOpenHomepage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadOpenHomepage
		$I->comment("Exiting Action Group [openHomepage] StorefrontOpenHomePageActionGroup");
		$I->comment("Entering Action Group [seeCategoryOnStoreNavigationBar] StorefrontAssertCategoryNameIsShownInMenuActionGroup");
		$I->seeElement("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategory', 'name', 'test') . "')]]"); // stepKey: seeCatergoryInStoreFrontSeeCategoryOnStoreNavigationBar
		$I->waitForPageLoad(30); // stepKey: seeCatergoryInStoreFrontSeeCategoryOnStoreNavigationBarWaitForPageLoad
		$I->comment("Exiting Action Group [seeCategoryOnStoreNavigationBar] StorefrontAssertCategoryNameIsShownInMenuActionGroup");
		$I->comment("Entering Action Group [doNotSeeSubCategoryOnStoreNavigation] StorefrontAssertCategoryNameIsNotShownInMenuActionGroup");
		$I->dontSeeElement("//nav//a[span[contains(., 'SimpleSubCategory" . msq("SimpleSubCategory") . "')]]"); // stepKey: doNotSeeCatergoryInStoreFrontDoNotSeeSubCategoryOnStoreNavigation
		$I->waitForPageLoad(30); // stepKey: doNotSeeCatergoryInStoreFrontDoNotSeeSubCategoryOnStoreNavigationWaitForPageLoad
		$I->comment("Exiting Action Group [doNotSeeSubCategoryOnStoreNavigation] StorefrontAssertCategoryNameIsNotShownInMenuActionGroup");
	}
}
