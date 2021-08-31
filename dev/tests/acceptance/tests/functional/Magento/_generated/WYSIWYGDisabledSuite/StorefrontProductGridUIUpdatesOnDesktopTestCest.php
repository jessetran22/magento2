<?php
namespace Magento\AcceptanceTest\_WYSIWYGDisabledSuite\Backend;

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
 * @Title("MC-27569: Storefront product grid UI updates on Desktop")
 * @Description("Storefront product grid UI updates on Desktop<h3>Test files</h3>app/code/Magento/CatalogWidget/Test/Mftf/Test/StorefrontProductGridUIUpdatesOnDesktopTest.xml<br>")
 * @TestCaseId("MC-27569")
 * @group catalog
 * @group WYSIWYGDisabled
 */
class StorefrontProductGridUIUpdatesOnDesktopTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("1. Create multiple products and assign to a category.");
		$I->createEntity("createCategory", "hook", "ApiCategory", [], []); // stepKey: createCategory
		$I->createEntity("createFirstSimpleProduct", "hook", "ApiSimpleProduct", ["createCategory"], []); // stepKey: createFirstSimpleProduct
		$I->createEntity("createSecondSimpleProduct", "hook", "ApiSimpleProduct", ["createCategory"], []); // stepKey: createSecondSimpleProduct
		$I->createEntity("createThirdSimpleProduct", "hook", "ApiSimpleProduct", ["createCategory"], []); // stepKey: createThirdSimpleProduct
		$I->createEntity("createFourthSimpleProduct", "hook", "ApiSimpleProduct", ["createCategory"], []); // stepKey: createFourthSimpleProduct
		$I->comment("2. Create new CMS page and add \"Catalog Product List\" widget type via content >insert  widget option");
		$I->createEntity("createCmsPage", "hook", "_emptyCmsPage", [], []); // stepKey: createCmsPage
		$I->comment("Entering Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginToAdminPanel
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginToAdminPanel
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginToAdminPanel
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginToAdminPanel
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginToAdminPanelWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginToAdminPanel
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginToAdminPanel
		$I->comment("Exiting Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->comment("Entering Action Group [navigateToCreatedCmsPage] NavigateToCreatedCMSPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page"); // stepKey: navigateToCMSPagesGridNavigateToCreatedCmsPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1NavigateToCreatedCmsPage
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[contains(text(), 'Clear all')]", "//div[@class='admin__data-grid-header']//span[contains(text(), 'Active filters:')]", true); // stepKey: clickToResetFilterNavigateToCreatedCmsPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2NavigateToCreatedCmsPage
		$I->conditionalClick("//div[contains(@data-role, 'grid-wrapper')]/table/thead/tr/th/span[contains(text(), 'ID')]", "//span[contains(text(), 'ID')]/parent::th[not(contains(@class, '_descend'))]/parent::tr/parent::thead/parent::table/parent::div[contains(@data-role, 'grid-wrapper')]", true); // stepKey: clickToAttemptSortByIdDescendingNavigateToCreatedCmsPage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForFirstIdSortDescendingToFinishNavigateToCreatedCmsPage
		$I->comment("Conditional Click again in case it goes from default state to ascending on first click");
		$I->conditionalClick("//div[contains(@data-role, 'grid-wrapper')]/table/thead/tr/th/span[contains(text(), 'ID')]", "//span[contains(text(), 'ID')]/parent::th[not(contains(@class, '_descend'))]/parent::tr/parent::thead/parent::table/parent::div[contains(@data-role, 'grid-wrapper')]", true); // stepKey: secondClickToAttemptSortByIdDescendingNavigateToCreatedCmsPage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSecondIdSortDescendingToFinishNavigateToCreatedCmsPage
		$I->click("//div[text()='" . $I->retrieveEntityField('createCmsPage', 'identifier', 'hook') . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//button[text()='Select']"); // stepKey: clickSelectCreatedCMSPageNavigateToCreatedCmsPage
		$I->click("//div[text()='" . $I->retrieveEntityField('createCmsPage', 'identifier', 'hook') . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//a[text()='Edit']"); // stepKey: navigateToCreatedCMSPageNavigateToCreatedCmsPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3NavigateToCreatedCmsPage
		$I->click("div[data-index=content]"); // stepKey: clickExpandContentTabForPageNavigateToCreatedCmsPage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskOfStagingSectionNavigateToCreatedCmsPage
		$I->comment("Exiting Action Group [navigateToCreatedCmsPage] NavigateToCreatedCMSPageActionGroup");
		$I->comment("Entering Action Group [insertWidgetToCmsPageContentActionGroup] AdminInsertWidgetToCmsPageContentActionGroup");
		$I->waitForElementVisible("//span[contains(text(),'Insert Widget...')]", 30); // stepKey: waitForInsertWidgetElementVisibleInsertWidgetToCmsPageContentActionGroup
		$I->click("//span[contains(text(),'Insert Widget...')]"); // stepKey: clickOnInsertWidgetButtonInsertWidgetToCmsPageContentActionGroup
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAfterClickOnInsertWidgetButtonInsertWidgetToCmsPageContentActionGroup
		$I->waitForElementVisible("//h1[contains(text(),'Insert Widget')]", 30); // stepKey: waitForInsertWidgetTitleInsertWidgetToCmsPageContentActionGroup
		$I->selectOption("#select_widget_type", "Catalog Products List"); // stepKey: selectWidgetTypeInsertWidgetToCmsPageContentActionGroup
		$I->comment("Exiting Action Group [insertWidgetToCmsPageContentActionGroup] AdminInsertWidgetToCmsPageContentActionGroup");
		$I->comment("Entering Action Group [fillCatalogProductsListWidgetOptions] AdminFillCatalogProductsListWidgetCategoryActionGroup");
		$I->waitForElementVisible(".rule-param-add", 30); // stepKey: waitForAddParamElementFillCatalogProductsListWidgetOptions
		$I->click(".rule-param-add"); // stepKey: clickOnAddParamElementFillCatalogProductsListWidgetOptions
		$I->waitForElementVisible("#conditions__1__new_child", 30); // stepKey: waitForConditionsDropdownVisibleFillCatalogProductsListWidgetOptions
		$I->selectOption("#conditions__1__new_child", "Category"); // stepKey: selectCategoryAsConditionFillCatalogProductsListWidgetOptions
		$I->waitForElementVisible("//a[text()='...']", 30); // stepKey: waitForRuleParamElementVisibleFillCatalogProductsListWidgetOptions
		$I->click("//a[text()='...']"); // stepKey: clickToAddRuleParamFillCatalogProductsListWidgetOptions
		$I->click("//img[@title='Open Chooser']"); // stepKey: clickToSelectFromListFillCatalogProductsListWidgetOptions
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAfterSelectingRuleParamFillCatalogProductsListWidgetOptions
		$I->waitForElementVisible(" //span[contains(text(),'" . $I->retrieveEntityField('createCategory', 'name', 'hook') . "')]", 30); // stepKey: waitForCategoryElementVisibleFillCatalogProductsListWidgetOptions
		$I->click(" //span[contains(text(),'" . $I->retrieveEntityField('createCategory', 'name', 'hook') . "')]"); // stepKey: selectCategoryFromArgumentsFillCatalogProductsListWidgetOptions
		$I->click(".rule-param-apply"); // stepKey: clickApplyButtonFillCatalogProductsListWidgetOptions
		$I->waitForElementNotVisible(".rule-chooser .tree.x-tree", 30); // stepKey: waitForCategoryTreeIsNotVisibleFillCatalogProductsListWidgetOptions
		$I->comment("Exiting Action Group [fillCatalogProductsListWidgetOptions] AdminFillCatalogProductsListWidgetCategoryActionGroup");
		$I->comment("Entering Action Group [clickInsertWidgetButton] AdminClickInsertWidgetActionGroup");
		$I->click("#insert_button"); // stepKey: clickInsertWidgetButtonClickInsertWidgetButton
		$I->waitForPageLoad(30); // stepKey: clickInsertWidgetButtonClickInsertWidgetButtonWaitForPageLoad
		$I->waitForElementNotVisible("//h1[contains(text(),'Insert Widget')]", 30); // stepKey: waitForWidgetPopupDisappearClickInsertWidgetButton
		$I->comment("Exiting Action Group [clickInsertWidgetButton] AdminClickInsertWidgetActionGroup");
		$I->comment("Entering Action Group [clickSaveButton] SaveCmsPageActionGroup");
		$I->waitForElementVisible("//button[@data-ui-id='save-button-dropdown']", 30); // stepKey: waitForSplitButtonClickSaveButton
		$I->waitForPageLoad(10); // stepKey: waitForSplitButtonClickSaveButtonWaitForPageLoad
		$I->click("//button[@data-ui-id='save-button-dropdown']"); // stepKey: expandSplitButtonClickSaveButton
		$I->waitForPageLoad(10); // stepKey: expandSplitButtonClickSaveButtonWaitForPageLoad
		$I->waitForElementVisible("#save_and_close", 30); // stepKey: waitForSaveCmsPageClickSaveButton
		$I->waitForPageLoad(10); // stepKey: waitForSaveCmsPageClickSaveButtonWaitForPageLoad
		$I->click("#save_and_close"); // stepKey: clickSaveCmsPageClickSaveButton
		$I->waitForPageLoad(10); // stepKey: clickSaveCmsPageClickSaveButtonWaitForPageLoad
		$I->waitForElementVisible("#add", 1); // stepKey: waitForCmsPageSaveButtonClickSaveButton
		$I->waitForPageLoad(30); // stepKey: waitForCmsPageSaveButtonClickSaveButtonWaitForPageLoad
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageClickSaveButton
		$I->see("You saved the page.", ".message-success"); // stepKey: assertSavePageSuccessMessageClickSaveButton
		$I->comment("Exiting Action Group [clickSaveButton] SaveCmsPageActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createFirstSimpleProduct", "hook"); // stepKey: deleteFirstSimpleProduct
		$I->deleteEntity("createSecondSimpleProduct", "hook"); // stepKey: deleteSecondSimpleProduct
		$I->deleteEntity("createThirdSimpleProduct", "hook"); // stepKey: deleteThirdSimpleProduct
		$I->deleteEntity("createFourthSimpleProduct", "hook"); // stepKey: deleteFourthSimpleProduct
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createCmsPage", "hook"); // stepKey: deleteCmsPage
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
	 * @Features({"CatalogWidget"})
	 * @Stories({"New products list widget"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontProductGridUIUpdatesOnDesktopTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateAndOpenCreatedCmsPage] StorefrontGoToCMSPageActionGroup");
		$I->amOnPage("//" . $I->retrieveEntityField('createCmsPage', 'identifier', 'test')); // stepKey: amOnCmsPageOnStorefrontNavigateAndOpenCreatedCmsPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOnStorefrontNavigateAndOpenCreatedCmsPage
		$I->comment("Exiting Action Group [navigateAndOpenCreatedCmsPage] StorefrontGoToCMSPageActionGroup");
		$I->comment("Entering Action Group [assertProductControlsAreNotVisibleWithoutHoverOnCmsPage] AssertStorefrontProductControlsAreNotVisibleWithoutHoverActionGroup");
		$I->dontSeeElement(".product-item-info:hover button.action.tocart.primary"); // stepKey: assertAddToCartButtonElementIsNotVisibleAssertProductControlsAreNotVisibleWithoutHoverOnCmsPage
		$I->waitForPageLoad(30); // stepKey: assertAddToCartButtonElementIsNotVisibleAssertProductControlsAreNotVisibleWithoutHoverOnCmsPageWaitForPageLoad
		$I->dontSeeElement(".product-item-info:hover a.action.towishlist"); // stepKey: assertAddToWishListIconIsNotVisibleAssertProductControlsAreNotVisibleWithoutHoverOnCmsPage
		$I->waitForPageLoad(30); // stepKey: assertAddToWishListIconIsNotVisibleAssertProductControlsAreNotVisibleWithoutHoverOnCmsPageWaitForPageLoad
		$I->dontSeeElement(".product-item-info:hover a.action.tocompare"); // stepKey: assertAddToCompareIconIsNotVisibleAssertProductControlsAreNotVisibleWithoutHoverOnCmsPage
		$I->waitForPageLoad(30); // stepKey: assertAddToCompareIconIsNotVisibleAssertProductControlsAreNotVisibleWithoutHoverOnCmsPageWaitForPageLoad
		$I->comment("Exiting Action Group [assertProductControlsAreNotVisibleWithoutHoverOnCmsPage] AssertStorefrontProductControlsAreNotVisibleWithoutHoverActionGroup");
		$I->seeElement("a.product-item-link[href$='" . $I->retrieveEntityField('createFirstSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html']"); // stepKey: assertProductName
		$I->seeElement("//a[contains(text(), '" . $I->retrieveEntityField('createFirstSimpleProduct', 'name', 'test') . "')]//ancestor::div[contains(@class, 'product-item-info')]//span[contains(@class, 'price')]"); // stepKey: assertProductPrice
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createFirstSimpleProduct', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: hoverProduct
		$I->comment("Entering Action Group [assertProductControlsAreVisibleOnHoverOnCmsPage] AssertStorefrontProductControlsAreVisibleOnHoverActionGroup");
		$I->seeElement(".product-item-info:hover button.action.tocart.primary"); // stepKey: assertAddToCartButtonElementIsVisibleAssertProductControlsAreVisibleOnHoverOnCmsPage
		$I->waitForPageLoad(30); // stepKey: assertAddToCartButtonElementIsVisibleAssertProductControlsAreVisibleOnHoverOnCmsPageWaitForPageLoad
		$I->seeElement(".product-item-info:hover a.action.towishlist"); // stepKey: assertAddToWishListIconIsVisibleAssertProductControlsAreVisibleOnHoverOnCmsPage
		$I->waitForPageLoad(30); // stepKey: assertAddToWishListIconIsVisibleAssertProductControlsAreVisibleOnHoverOnCmsPageWaitForPageLoad
		$I->seeElement(".product-item-info:hover a.action.tocompare"); // stepKey: assertAddToCompareIconIsVisibleAssertProductControlsAreVisibleOnHoverOnCmsPage
		$I->waitForPageLoad(30); // stepKey: assertAddToCompareIconIsVisibleAssertProductControlsAreVisibleOnHoverOnCmsPageWaitForPageLoad
		$I->comment("Exiting Action Group [assertProductControlsAreVisibleOnHoverOnCmsPage] AssertStorefrontProductControlsAreVisibleOnHoverActionGroup");
		$I->comment("Entering Action Group [assertAddToWishListIconIsClickable] AssertStorefrontAddToWishListIconIsClickableForGuestUserActionGroup");
		$I->moveMouseOver(".product-item-info"); // stepKey: hoverProductAssertAddToWishListIconIsClickable
		$I->click(".product-item-info:hover a.action.towishlist"); // stepKey: clickOnAddToWishListIconAssertAddToWishListIconIsClickable
		$I->waitForPageLoad(30); // stepKey: clickOnAddToWishListIconAssertAddToWishListIconIsClickableWaitForPageLoad
		$I->waitForElementVisible(".message-error", 30); // stepKey: waitForErrorMessageIsVisibleAssertAddToWishListIconIsClickable
		$I->see("You must login or register to add items to your wishlist.", ".message-error"); // stepKey: assertErrorMessageAssertAddToWishListIconIsClickable
		$I->seeInCurrentUrl("/customer/account/login/"); // stepKey: assertCustomerLoginPageUrlAssertAddToWishListIconIsClickable
		$I->comment("Exiting Action Group [assertAddToWishListIconIsClickable] AssertStorefrontAddToWishListIconIsClickableForGuestUserActionGroup");
		$I->comment("Entering Action Group [navigateAndOpenCreatedCmsPageToVerifyAddToCompareIconIsClickable] StorefrontGoToCMSPageActionGroup");
		$I->amOnPage("//" . $I->retrieveEntityField('createCmsPage', 'identifier', 'test')); // stepKey: amOnCmsPageOnStorefrontNavigateAndOpenCreatedCmsPageToVerifyAddToCompareIconIsClickable
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOnStorefrontNavigateAndOpenCreatedCmsPageToVerifyAddToCompareIconIsClickable
		$I->comment("Exiting Action Group [navigateAndOpenCreatedCmsPageToVerifyAddToCompareIconIsClickable] StorefrontGoToCMSPageActionGroup");
		$I->comment("Entering Action Group [assertAddToCompareIconIsClickable] StorefrontAddCategoryProductToCompareActionGroup");
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createFirstSimpleProduct', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: moveMouseOverProductAssertAddToCompareIconIsClickable
		$I->click("//*[contains(@class,'product-item-info')][descendant::a[contains(text(), '" . $I->retrieveEntityField('createFirstSimpleProduct', 'name', 'test') . "')]]//a[contains(@class, 'tocompare')]"); // stepKey: clickAddProductToCompareAssertAddToCompareIconIsClickable
		$I->waitForElement("div.message-success.success.message", 30); // stepKey: waitForAddCategoryProductToCompareSuccessMessageAssertAddToCompareIconIsClickable
		$I->see("You added product " . $I->retrieveEntityField('createFirstSimpleProduct', 'name', 'test') . " to the comparison list.", "div.message-success.success.message"); // stepKey: assertAddCategoryProductToCompareSuccessMessageAssertAddToCompareIconIsClickable
		$I->comment("Exiting Action Group [assertAddToCompareIconIsClickable] StorefrontAddCategoryProductToCompareActionGroup");
		$I->comment("Entering Action Group [navigateCategoryCreatedInPreconditions] StorefrontNavigateCategoryPageActionGroup");
		$I->comment("Open category page on storefront");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateStorefrontCategoryPageNavigateCategoryCreatedInPreconditions
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoadNavigateCategoryCreatedInPreconditions
		$I->comment("Exiting Action Group [navigateCategoryCreatedInPreconditions] StorefrontNavigateCategoryPageActionGroup");
		$I->comment("Entering Action Group [assertProductControlsAreNotVisibleWithoutHoverOnCategoryPage] AssertStorefrontProductControlsAreNotVisibleWithoutHoverActionGroup");
		$I->dontSeeElement(".product-item-info:hover button.action.tocart.primary"); // stepKey: assertAddToCartButtonElementIsNotVisibleAssertProductControlsAreNotVisibleWithoutHoverOnCategoryPage
		$I->waitForPageLoad(30); // stepKey: assertAddToCartButtonElementIsNotVisibleAssertProductControlsAreNotVisibleWithoutHoverOnCategoryPageWaitForPageLoad
		$I->dontSeeElement(".product-item-info:hover a.action.towishlist"); // stepKey: assertAddToWishListIconIsNotVisibleAssertProductControlsAreNotVisibleWithoutHoverOnCategoryPage
		$I->waitForPageLoad(30); // stepKey: assertAddToWishListIconIsNotVisibleAssertProductControlsAreNotVisibleWithoutHoverOnCategoryPageWaitForPageLoad
		$I->dontSeeElement(".product-item-info:hover a.action.tocompare"); // stepKey: assertAddToCompareIconIsNotVisibleAssertProductControlsAreNotVisibleWithoutHoverOnCategoryPage
		$I->waitForPageLoad(30); // stepKey: assertAddToCompareIconIsNotVisibleAssertProductControlsAreNotVisibleWithoutHoverOnCategoryPageWaitForPageLoad
		$I->comment("Exiting Action Group [assertProductControlsAreNotVisibleWithoutHoverOnCategoryPage] AssertStorefrontProductControlsAreNotVisibleWithoutHoverActionGroup");
		$I->seeElement("a.product-item-link[href$='" . $I->retrieveEntityField('createFirstSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html']"); // stepKey: assertProductNameOnCategoryPage
		$I->seeElement("//a[contains(text(), '" . $I->retrieveEntityField('createFirstSimpleProduct', 'name', 'test') . "')]//ancestor::div[contains(@class, 'product-item-info')]//span[contains(@class, 'price')]"); // stepKey: assertProductPriceOnCategoryPage
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createFirstSimpleProduct', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: hoverProductOnCategoryPage
		$I->comment("Entering Action Group [assertProductControlsAreVisibleOnHoverOnCategoryPage] AssertStorefrontProductControlsAreVisibleOnHoverActionGroup");
		$I->seeElement(".product-item-info:hover button.action.tocart.primary"); // stepKey: assertAddToCartButtonElementIsVisibleAssertProductControlsAreVisibleOnHoverOnCategoryPage
		$I->waitForPageLoad(30); // stepKey: assertAddToCartButtonElementIsVisibleAssertProductControlsAreVisibleOnHoverOnCategoryPageWaitForPageLoad
		$I->seeElement(".product-item-info:hover a.action.towishlist"); // stepKey: assertAddToWishListIconIsVisibleAssertProductControlsAreVisibleOnHoverOnCategoryPage
		$I->waitForPageLoad(30); // stepKey: assertAddToWishListIconIsVisibleAssertProductControlsAreVisibleOnHoverOnCategoryPageWaitForPageLoad
		$I->seeElement(".product-item-info:hover a.action.tocompare"); // stepKey: assertAddToCompareIconIsVisibleAssertProductControlsAreVisibleOnHoverOnCategoryPage
		$I->waitForPageLoad(30); // stepKey: assertAddToCompareIconIsVisibleAssertProductControlsAreVisibleOnHoverOnCategoryPageWaitForPageLoad
		$I->comment("Exiting Action Group [assertProductControlsAreVisibleOnHoverOnCategoryPage] AssertStorefrontProductControlsAreVisibleOnHoverActionGroup");
		$I->comment("Entering Action Group [assertAddToWishListIconIsClickableOnCategoryPage] AssertStorefrontAddToWishListIconIsClickableForGuestUserActionGroup");
		$I->moveMouseOver(".product-item-info"); // stepKey: hoverProductAssertAddToWishListIconIsClickableOnCategoryPage
		$I->click(".product-item-info:hover a.action.towishlist"); // stepKey: clickOnAddToWishListIconAssertAddToWishListIconIsClickableOnCategoryPage
		$I->waitForPageLoad(30); // stepKey: clickOnAddToWishListIconAssertAddToWishListIconIsClickableOnCategoryPageWaitForPageLoad
		$I->waitForElementVisible(".message-error", 30); // stepKey: waitForErrorMessageIsVisibleAssertAddToWishListIconIsClickableOnCategoryPage
		$I->see("You must login or register to add items to your wishlist.", ".message-error"); // stepKey: assertErrorMessageAssertAddToWishListIconIsClickableOnCategoryPage
		$I->seeInCurrentUrl("/customer/account/login/"); // stepKey: assertCustomerLoginPageUrlAssertAddToWishListIconIsClickableOnCategoryPage
		$I->comment("Exiting Action Group [assertAddToWishListIconIsClickableOnCategoryPage] AssertStorefrontAddToWishListIconIsClickableForGuestUserActionGroup");
		$I->comment("Entering Action Group [navigateCategoryCreatedInPreconditionsToVerifyAddToCompareIconIsClickable] StorefrontNavigateCategoryPageActionGroup");
		$I->comment("Open category page on storefront");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateStorefrontCategoryPageNavigateCategoryCreatedInPreconditionsToVerifyAddToCompareIconIsClickable
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoadNavigateCategoryCreatedInPreconditionsToVerifyAddToCompareIconIsClickable
		$I->comment("Exiting Action Group [navigateCategoryCreatedInPreconditionsToVerifyAddToCompareIconIsClickable] StorefrontNavigateCategoryPageActionGroup");
		$I->comment("Entering Action Group [assertAddToCompareIconIsClickableOnCategoryPage] StorefrontAddCategoryProductToCompareActionGroup");
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createFirstSimpleProduct', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: moveMouseOverProductAssertAddToCompareIconIsClickableOnCategoryPage
		$I->click("//*[contains(@class,'product-item-info')][descendant::a[contains(text(), '" . $I->retrieveEntityField('createFirstSimpleProduct', 'name', 'test') . "')]]//a[contains(@class, 'tocompare')]"); // stepKey: clickAddProductToCompareAssertAddToCompareIconIsClickableOnCategoryPage
		$I->waitForElement("div.message-success.success.message", 30); // stepKey: waitForAddCategoryProductToCompareSuccessMessageAssertAddToCompareIconIsClickableOnCategoryPage
		$I->see("You added product " . $I->retrieveEntityField('createFirstSimpleProduct', 'name', 'test') . " to the comparison list.", "div.message-success.success.message"); // stepKey: assertAddCategoryProductToCompareSuccessMessageAssertAddToCompareIconIsClickableOnCategoryPage
		$I->comment("Exiting Action Group [assertAddToCompareIconIsClickableOnCategoryPage] StorefrontAddCategoryProductToCompareActionGroup");
		$I->comment("Entering Action Group [clearAllCompareProducts] StorefrontClearCompareActionGroup");
		$I->waitForElementVisible("//main//div[contains(@class, 'block-compare')]//a[contains(@class, 'action clear')]", 30); // stepKey: waitForClearAllClearAllCompareProducts
		$I->click("//main//div[contains(@class, 'block-compare')]//a[contains(@class, 'action clear')]"); // stepKey: clickClearAllClearAllCompareProducts
		$I->waitForElementVisible("//footer[@class='modal-footer']/button[contains(@class, 'action-accept')]", 30); // stepKey: waitForClearOkClearAllCompareProducts
		$I->waitForPageLoad(30); // stepKey: waitForClearOkClearAllCompareProductsWaitForPageLoad
		$I->scrollTo("//footer[@class='modal-footer']/button[contains(@class, 'action-accept')]"); // stepKey: scrollToClearOkClearAllCompareProducts
		$I->waitForPageLoad(30); // stepKey: scrollToClearOkClearAllCompareProductsWaitForPageLoad
		$I->click("//footer[@class='modal-footer']/button[contains(@class, 'action-accept')]"); // stepKey: clickClearOkClearAllCompareProducts
		$I->waitForPageLoad(30); // stepKey: clickClearOkClearAllCompareProductsWaitForPageLoad
		$I->waitForElementVisible("//main//div[contains(@class, 'messages')]//div[contains(@class, 'message')]/div[contains(text(), 'You cleared the comparison list.')]", 30); // stepKey: assertMessageClearedClearAllCompareProducts
		$I->waitForElementVisible("//main//div[contains(@class, 'block-compare')]//div[@class='empty']", 30); // stepKey: assertNoItemsClearAllCompareProducts
		$I->comment("Exiting Action Group [clearAllCompareProducts] StorefrontClearCompareActionGroup");
	}
}
