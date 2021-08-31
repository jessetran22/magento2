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
 * @Title("MAGETWO-72238: Customer should not see categories that are not included in the menu")
 * @Description("Customer should not see categories that are not included in the menu<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/VerifyChildCategoriesShouldNotIncludeInMenuTest.xml<br>")
 * @TestCaseId("MAGETWO-72238")
 * @group category
 */
class VerifyChildCategoriesShouldNotIncludeInMenuTestCest
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
		$I->comment("Create a category");
		$I->createEntity("simpleCategory", "hook", "ApiCategory", [], []); // stepKey: simpleCategory
		$I->comment("Create second category, having as parent the 1st one");
		$I->createEntity("simpleSubCategory", "hook", "SubCategoryWithParent", ["simpleCategory"], []); // stepKey: simpleSubCategory
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("simpleSubCategory", "hook"); // stepKey: deleteSubCategory
		$I->deleteEntity("simpleCategory", "hook"); // stepKey: deleteCategory
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
	 * @Features({"Catalog"})
	 * @Stories({"Create categories"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function VerifyChildCategoriesShouldNotIncludeInMenuTest(AcceptanceTester $I)
	{
		$I->comment("Go to storefront and verify visibility of categories");
		$I->comment("Entering Action Group [goToStorefrontPage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToStorefrontPage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToStorefrontPage
		$I->comment("Exiting Action Group [goToStorefrontPage] StorefrontOpenHomePageActionGroup");
		$I->comment("Entering Action Group [seeCreatedCategoryOnStorefront] StorefrontAssertCategoryNameIsShownInMenuActionGroup");
		$I->seeElement("//nav//a[span[contains(., '" . $I->retrieveEntityField('simpleCategory', 'name', 'test') . "')]]"); // stepKey: seeCatergoryInStoreFrontSeeCreatedCategoryOnStorefront
		$I->waitForPageLoad(30); // stepKey: seeCatergoryInStoreFrontSeeCreatedCategoryOnStorefrontWaitForPageLoad
		$I->comment("Exiting Action Group [seeCreatedCategoryOnStorefront] StorefrontAssertCategoryNameIsShownInMenuActionGroup");
		$I->comment("Entering Action Group [doNotSeeSubCategoryOnStorefront] StorefrontAssertCategoryNameIsNotShownInMenuActionGroup");
		$I->dontSeeElement("//nav//a[span[contains(., '" . $I->retrieveEntityField('simpleSubCategory', 'name', 'test') . "')]]"); // stepKey: doNotSeeCatergoryInStoreFrontDoNotSeeSubCategoryOnStorefront
		$I->waitForPageLoad(30); // stepKey: doNotSeeCatergoryInStoreFrontDoNotSeeSubCategoryOnStorefrontWaitForPageLoad
		$I->comment("Exiting Action Group [doNotSeeSubCategoryOnStorefront] StorefrontAssertCategoryNameIsNotShownInMenuActionGroup");
		$I->comment("Set Include in menu to No on created category under Default Category");
		$I->comment("Entering Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginToAdminPanel
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginToAdminPanel
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginToAdminPanel
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginToAdminPanel
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginToAdminPanelWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginToAdminPanel
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginToAdminPanel
		$I->comment("Exiting Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->comment("Entering Action Group [openParentCategoryViaAdmin] NavigateToCreatedCategoryActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: amOnCategoryPageOpenParentCategoryViaAdmin
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1OpenParentCategoryViaAdmin
		$I->click(".tree-actions a:last-child"); // stepKey: expandAllOpenParentCategoryViaAdmin
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2OpenParentCategoryViaAdmin
		$I->click("//a/span[contains(text(), '" . $I->retrieveEntityField('simpleCategory', 'Name', 'test') . "')]"); // stepKey: navigateToCreatedCategoryOpenParentCategoryViaAdmin
		$I->waitForPageLoad(30); // stepKey: navigateToCreatedCategoryOpenParentCategoryViaAdminWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSpinnerOpenParentCategoryViaAdmin
		$I->comment("Exiting Action Group [openParentCategoryViaAdmin] NavigateToCreatedCategoryActionGroup");
		$I->comment("Entering Action Group [setNoToIncludeInMenuSelect] AdminDisableIncludeInMenuConfigActionGroup");
		$I->click("input[name='include_in_menu']+label"); // stepKey: setIncludeInMenuSelectToNoSetNoToIncludeInMenuSelect
		$I->comment("Exiting Action Group [setNoToIncludeInMenuSelect] AdminDisableIncludeInMenuConfigActionGroup");
		$I->comment("Entering Action Group [saveCategory] AdminSaveCategoryActionGroup");
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryWithProductsSaveCategory
		$I->waitForPageLoad(30); // stepKey: saveCategoryWithProductsSaveCategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategorySavedSaveCategory
		$I->comment("Exiting Action Group [saveCategory] AdminSaveCategoryActionGroup");
		$I->comment("Entering Action Group [assertParentCategoryIsActive] AssertAdminCategoryIsEnabledActionGroup");
		$I->seeCheckboxIsChecked("input[name='is_active']"); // stepKey: seeCategoryIsEnabledAssertParentCategoryIsActive
		$I->comment("Exiting Action Group [assertParentCategoryIsActive] AssertAdminCategoryIsEnabledActionGroup");
		$I->comment("Entering Action Group [assertParentCategoryIsNotIncludeInMenu] AssertAdminCategoryIsNotIncludeInMenuActionGroup");
		$I->dontSeeCheckboxIsChecked("input[name='include_in_menu']"); // stepKey: dontSeeCategoryIncludeInMenuAssertParentCategoryIsNotIncludeInMenu
		$I->comment("Exiting Action Group [assertParentCategoryIsNotIncludeInMenu] AssertAdminCategoryIsNotIncludeInMenuActionGroup");
		$I->comment("Go to storefront and verify visibility of categories");
		$I->comment("Entering Action Group [goToStorefrontPageSecondTime] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToStorefrontPageSecondTime
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToStorefrontPageSecondTime
		$I->comment("Exiting Action Group [goToStorefrontPageSecondTime] StorefrontOpenHomePageActionGroup");
		$I->comment("Entering Action Group [doNotSeeParentCategoryOnStorefront] StorefrontAssertCategoryNameIsNotShownInMenuActionGroup");
		$I->dontSeeElement("//nav//a[span[contains(., '" . $I->retrieveEntityField('simpleCategory', 'name', 'test') . "')]]"); // stepKey: doNotSeeCatergoryInStoreFrontDoNotSeeParentCategoryOnStorefront
		$I->waitForPageLoad(30); // stepKey: doNotSeeCatergoryInStoreFrontDoNotSeeParentCategoryOnStorefrontWaitForPageLoad
		$I->comment("Exiting Action Group [doNotSeeParentCategoryOnStorefront] StorefrontAssertCategoryNameIsNotShownInMenuActionGroup");
		$I->comment("Entering Action Group [doNotSeeSubCategory] StorefrontAssertCategoryNameIsNotShownInMenuActionGroup");
		$I->dontSeeElement("//nav//a[span[contains(., '" . $I->retrieveEntityField('simpleSubCategory', 'name', 'test') . "')]]"); // stepKey: doNotSeeCatergoryInStoreFrontDoNotSeeSubCategory
		$I->waitForPageLoad(30); // stepKey: doNotSeeCatergoryInStoreFrontDoNotSeeSubCategoryWaitForPageLoad
		$I->comment("Exiting Action Group [doNotSeeSubCategory] StorefrontAssertCategoryNameIsNotShownInMenuActionGroup");
		$I->comment("Set Enable category to No and Include in menu to Yes on created category under Default Category");
		$I->comment("Entering Action Group [openParentCategoryViaAdminSecondTime] NavigateToCreatedCategoryActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: amOnCategoryPageOpenParentCategoryViaAdminSecondTime
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1OpenParentCategoryViaAdminSecondTime
		$I->click(".tree-actions a:last-child"); // stepKey: expandAllOpenParentCategoryViaAdminSecondTime
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2OpenParentCategoryViaAdminSecondTime
		$I->click("//a/span[contains(text(), '" . $I->retrieveEntityField('simpleCategory', 'Name', 'test') . "')]"); // stepKey: navigateToCreatedCategoryOpenParentCategoryViaAdminSecondTime
		$I->waitForPageLoad(30); // stepKey: navigateToCreatedCategoryOpenParentCategoryViaAdminSecondTimeWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSpinnerOpenParentCategoryViaAdminSecondTime
		$I->comment("Exiting Action Group [openParentCategoryViaAdminSecondTime] NavigateToCreatedCategoryActionGroup");
		$I->comment("Entering Action Group [SetNoToEnableCategorySelect] AdminDisableActiveCategoryActionGroup");
		$I->click("input[name='is_active']+label"); // stepKey: disableActiveCategorySetNoToEnableCategorySelect
		$I->comment("Exiting Action Group [SetNoToEnableCategorySelect] AdminDisableActiveCategoryActionGroup");
		$I->comment("Entering Action Group [SetToYesIncludeInMenuSelect] AdminIncludeInMenuExcludedCategoryActionGroup");
		$I->click("input[name='include_in_menu']+label"); // stepKey: includeToMenuCategorySetToYesIncludeInMenuSelect
		$I->comment("Exiting Action Group [SetToYesIncludeInMenuSelect] AdminIncludeInMenuExcludedCategoryActionGroup");
		$I->comment("Entering Action Group [saveParentCategory] AdminSaveCategoryActionGroup");
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryWithProductsSaveParentCategory
		$I->waitForPageLoad(30); // stepKey: saveCategoryWithProductsSaveParentCategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategorySavedSaveParentCategory
		$I->comment("Exiting Action Group [saveParentCategory] AdminSaveCategoryActionGroup");
		$I->comment("Entering Action Group [seeCategoryIsDisabled] AssertAdminCategoryIsInactiveActionGroup");
		$I->dontSeeCheckboxIsChecked("input[name='is_active']"); // stepKey: seeCategoryIsDisabledSeeCategoryIsDisabled
		$I->comment("Exiting Action Group [seeCategoryIsDisabled] AssertAdminCategoryIsInactiveActionGroup");
		$I->comment("Entering Action Group [seeCheckboxIncludeInMenuIsChecked] AssertAdminCategoryIncludedToMenuActionGroup");
		$I->seeCheckboxIsChecked("input[name='include_in_menu']"); // stepKey: seeCheckboxIncludeInMenuIsCheckedSeeCheckboxIncludeInMenuIsChecked
		$I->comment("Exiting Action Group [seeCheckboxIncludeInMenuIsChecked] AssertAdminCategoryIncludedToMenuActionGroup");
		$I->comment("Go to storefront and verify visibility of categories");
		$I->comment("Entering Action Group [goToStorefrontPageThirdTime] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToStorefrontPageThirdTime
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToStorefrontPageThirdTime
		$I->comment("Exiting Action Group [goToStorefrontPageThirdTime] StorefrontOpenHomePageActionGroup");
		$I->comment("Entering Action Group [doNotSeeCategoryInMenuOnStorefront] StorefrontAssertCategoryNameIsNotShownInMenuActionGroup");
		$I->dontSeeElement("//nav//a[span[contains(., '" . $I->retrieveEntityField('simpleCategory', 'name', 'test') . "')]]"); // stepKey: doNotSeeCatergoryInStoreFrontDoNotSeeCategoryInMenuOnStorefront
		$I->waitForPageLoad(30); // stepKey: doNotSeeCatergoryInStoreFrontDoNotSeeCategoryInMenuOnStorefrontWaitForPageLoad
		$I->comment("Exiting Action Group [doNotSeeCategoryInMenuOnStorefront] StorefrontAssertCategoryNameIsNotShownInMenuActionGroup");
		$I->comment("Entering Action Group [doNotSeeSubCategoryInMenuOnStorefront] StorefrontAssertCategoryNameIsNotShownInMenuActionGroup");
		$I->dontSeeElement("//nav//a[span[contains(., '" . $I->retrieveEntityField('simpleSubCategory', 'name', 'test') . "')]]"); // stepKey: doNotSeeCatergoryInStoreFrontDoNotSeeSubCategoryInMenuOnStorefront
		$I->waitForPageLoad(30); // stepKey: doNotSeeCatergoryInStoreFrontDoNotSeeSubCategoryInMenuOnStorefrontWaitForPageLoad
		$I->comment("Exiting Action Group [doNotSeeSubCategoryInMenuOnStorefront] StorefrontAssertCategoryNameIsNotShownInMenuActionGroup");
		$I->comment("Set Enable category to No and Include in menu to No on created category under Default Category");
		$I->comment("Entering Action Group [openParentCategoryViaAdminThirdTime] NavigateToCreatedCategoryActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: amOnCategoryPageOpenParentCategoryViaAdminThirdTime
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1OpenParentCategoryViaAdminThirdTime
		$I->click(".tree-actions a:last-child"); // stepKey: expandAllOpenParentCategoryViaAdminThirdTime
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2OpenParentCategoryViaAdminThirdTime
		$I->click("//a/span[contains(text(), '" . $I->retrieveEntityField('simpleCategory', 'Name', 'test') . "')]"); // stepKey: navigateToCreatedCategoryOpenParentCategoryViaAdminThirdTime
		$I->waitForPageLoad(30); // stepKey: navigateToCreatedCategoryOpenParentCategoryViaAdminThirdTimeWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSpinnerOpenParentCategoryViaAdminThirdTime
		$I->comment("Exiting Action Group [openParentCategoryViaAdminThirdTime] NavigateToCreatedCategoryActionGroup");
		$I->comment("Entering Action Group [setNoToIncludeInMenuForParentCategory] AdminDisableIncludeInMenuConfigActionGroup");
		$I->click("input[name='include_in_menu']+label"); // stepKey: setIncludeInMenuSelectToNoSetNoToIncludeInMenuForParentCategory
		$I->comment("Exiting Action Group [setNoToIncludeInMenuForParentCategory] AdminDisableIncludeInMenuConfigActionGroup");
		$I->comment("Entering Action Group [saveChanges] AdminSaveCategoryActionGroup");
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryWithProductsSaveChanges
		$I->waitForPageLoad(30); // stepKey: saveCategoryWithProductsSaveChangesWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategorySavedSaveChanges
		$I->comment("Exiting Action Group [saveChanges] AdminSaveCategoryActionGroup");
		$I->comment("Entering Action Group [assertCategoryIsDisabled] AssertAdminCategoryIsInactiveActionGroup");
		$I->dontSeeCheckboxIsChecked("input[name='is_active']"); // stepKey: seeCategoryIsDisabledAssertCategoryIsDisabled
		$I->comment("Exiting Action Group [assertCategoryIsDisabled] AssertAdminCategoryIsInactiveActionGroup");
		$I->comment("Entering Action Group [assertParentCategoryIsNotIncludeToMenu] AssertAdminCategoryIsNotIncludeInMenuActionGroup");
		$I->dontSeeCheckboxIsChecked("input[name='include_in_menu']"); // stepKey: dontSeeCategoryIncludeInMenuAssertParentCategoryIsNotIncludeToMenu
		$I->comment("Exiting Action Group [assertParentCategoryIsNotIncludeToMenu] AssertAdminCategoryIsNotIncludeInMenuActionGroup");
		$I->comment("Go to storefront and verify visibility of categories");
		$I->comment("Entering Action Group [goToStorefrontPageFourthTime] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToStorefrontPageFourthTime
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToStorefrontPageFourthTime
		$I->comment("Exiting Action Group [goToStorefrontPageFourthTime] StorefrontOpenHomePageActionGroup");
		$I->comment("Entering Action Group [doNotSeeCategoryOnStorefront] StorefrontAssertCategoryNameIsNotShownInMenuActionGroup");
		$I->dontSeeElement("//nav//a[span[contains(., '" . $I->retrieveEntityField('simpleCategory', 'name', 'test') . "')]]"); // stepKey: doNotSeeCatergoryInStoreFrontDoNotSeeCategoryOnStorefront
		$I->waitForPageLoad(30); // stepKey: doNotSeeCatergoryInStoreFrontDoNotSeeCategoryOnStorefrontWaitForPageLoad
		$I->comment("Exiting Action Group [doNotSeeCategoryOnStorefront] StorefrontAssertCategoryNameIsNotShownInMenuActionGroup");
		$I->comment("Entering Action Group [doNotSeeSubCategoryInMenu] StorefrontAssertCategoryNameIsNotShownInMenuActionGroup");
		$I->dontSeeElement("//nav//a[span[contains(., '" . $I->retrieveEntityField('simpleSubCategory', 'name', 'test') . "')]]"); // stepKey: doNotSeeCatergoryInStoreFrontDoNotSeeSubCategoryInMenu
		$I->waitForPageLoad(30); // stepKey: doNotSeeCatergoryInStoreFrontDoNotSeeSubCategoryInMenuWaitForPageLoad
		$I->comment("Exiting Action Group [doNotSeeSubCategoryInMenu] StorefrontAssertCategoryNameIsNotShownInMenuActionGroup");
	}
}
