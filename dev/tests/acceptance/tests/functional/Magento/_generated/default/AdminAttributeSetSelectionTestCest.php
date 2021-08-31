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
 * @Title("MC-221: Admin should be able to select/edit the “Attributes Set” when creating/editing a bundle product")
 * @Description("Admin should be able to select/edit the “Attributes Set” when creating/editing a bundle product<h3>Test files</h3>app/code/Magento/Bundle/Test/Mftf/Test/AdminAttributeSetSelectionTest.xml<br>")
 * @TestCaseId("MC-221")
 * @group Bundle
 */
class AdminAttributeSetSelectionTestCest
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
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [amOnLogoutPage] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAmOnLogoutPage
		$I->comment("Exiting Action Group [amOnLogoutPage] AdminLogoutActionGroup");
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
	 * @Features({"Bundle"})
	 * @Stories({"Create/Edit bundle product in Admin"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminAttributeSetSelectionTest(AcceptanceTester $I)
	{
		$I->comment("Create a new attribute set");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_set/"); // stepKey: goToAttributeSets
		$I->waitForPageLoad(30); // stepKey: wait1
		$I->click("button.add-set"); // stepKey: clickAddAttributeSet
		$I->waitForPageLoad(30); // stepKey: clickAddAttributeSetWaitForPageLoad
		$I->fillField("#attribute_set_name", "attribute" . msq("ProductAttributeFrontendLabel")); // stepKey: fillName
		$I->selectOption("#skeleton_set", "Default"); // stepKey: selectDefaultSet
		$I->click("button.save-attribute-set"); // stepKey: clickSave1
		$I->waitForPageLoad(30); // stepKey: clickSave1WaitForPageLoad
		$I->dragAndDrop("//span[text()='meta_keyword']", "//span[text()='manufacturer']"); // stepKey: unassign1
		$I->click("button.add"); // stepKey: clickAddNewGroup
		$I->waitForPageLoad(30); // stepKey: clickAddNewGroupWaitForPageLoad
		$I->fillField("input[name='name']", "TestGroupName"); // stepKey: fillNewGroupName
		$I->click("button.action-accept"); // stepKey: clickOkInModal
		$I->waitForPageLoad(30); // stepKey: clickOkInModalWaitForPageLoad
		$I->dragAndDrop("//span[text()='manufacturer']", "//span[text()='TestGroupName']"); // stepKey: assignManufacturer
		$I->click("button.save-attribute-set"); // stepKey: clickSave2
		$I->waitForPageLoad(30); // stepKey: clickSave2WaitForPageLoad
		$I->comment("Go to new product page and see a default attribute");
		$I->comment("Switch from default attribute set to new attribute set");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/new/set/4/type/bundle/"); // stepKey: goToNewProductPage
		$I->waitForPageLoad(30); // stepKey: wait2
		$I->comment("Entering Action Group [startEditAttrSet] AdminSelectAttributeSetOnEditProductPageActionGroup");
		$I->click("div[data-index='attribute_set_id'] .admin__field-control"); // stepKey: clickAttributeSetDropdownStartEditAttrSet
		$I->fillField("div[data-index='attribute_set_id'] .admin__field-control input", "attribute" . msq("ProductAttributeFrontendLabel")); // stepKey: searchForAttributeSetStartEditAttrSet
		$I->waitForPageLoad(30); // stepKey: searchForAttributeSetStartEditAttrSetWaitForPageLoad
		$I->click("div[data-index='attribute_set_id'] .action-menu-item._last"); // stepKey: selectAttributeSetStartEditAttrSet
		$I->waitForPageLoad(30); // stepKey: selectAttributeSetStartEditAttrSetWaitForPageLoad
		$I->comment("Exiting Action Group [startEditAttrSet] AdminSelectAttributeSetOnEditProductPageActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->fillField("//*[@name='product[name]']", "BundleProduct" . msq("BundleProduct")); // stepKey: fillProductName
		$I->fillField("//*[@name='product[sku]']", "bundleproduct" . msq("BundleProduct")); // stepKey: fillProductSku
		$I->comment("save the product/published by default");
		$I->comment("Entering Action Group [clickSaveButton] AdminProductFormSaveActionGroup");
		$I->click("#save-button"); // stepKey: saveProductClickSaveButton
		$I->waitForPageLoad(30); // stepKey: saveProductClickSaveButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavingClickSaveButton
		$I->comment("Exiting Action Group [clickSaveButton] AdminProductFormSaveActionGroup");
		$I->seeElement(".message-success"); // stepKey: messageYouSavedTheProductIsShown
		$I->comment("Testing that price appears correctly in admin catalog");
		$I->comment("Set filter to product name");
		$I->comment("Entering Action Group [goToCatalogProductPage] AdminOpenCatalogProductPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: openCatalogProductPageGoToCatalogProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadGoToCatalogProductPage
		$I->comment("Exiting Action Group [goToCatalogProductPage] AdminOpenCatalogProductPageActionGroup");
		$I->comment("Entering Action Group [filterBundleProductOptionsDownToName] FilterProductGridByNameActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterBundleProductOptionsDownToName
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterBundleProductOptionsDownToNameWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterBundleProductOptionsDownToName
		$I->fillField("input.admin__control-text[name='name']", "BundleProduct" . msq("BundleProduct")); // stepKey: fillProductNameFilterFilterBundleProductOptionsDownToName
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterBundleProductOptionsDownToName
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterBundleProductOptionsDownToNameWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterBundleProductOptionsDownToName
		$I->comment("Exiting Action Group [filterBundleProductOptionsDownToName] FilterProductGridByNameActionGroup");
		$I->seeElement("//tr[@data-repeat-index='0']//div[contains(., 'attribute" . msq("ProductAttributeFrontendLabel") . "')]"); // stepKey: seeAttributeSet
		$I->comment("Editing Attribute set");
		$I->click("//tr[@data-repeat-index='0']//div[contains(., 'attribute" . msq("ProductAttributeFrontendLabel") . "')]"); // stepKey: clickAttributeSet2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2
		$I->comment("Entering Action Group [startEditAttrSet2] AdminSelectAttributeSetOnEditProductPageActionGroup");
		$I->click("div[data-index='attribute_set_id'] .admin__field-control"); // stepKey: clickAttributeSetDropdownStartEditAttrSet2
		$I->fillField("div[data-index='attribute_set_id'] .admin__field-control input", "Default"); // stepKey: searchForAttributeSetStartEditAttrSet2
		$I->waitForPageLoad(30); // stepKey: searchForAttributeSetStartEditAttrSet2WaitForPageLoad
		$I->click("div[data-index='attribute_set_id'] .action-menu-item._last"); // stepKey: selectAttributeSetStartEditAttrSet2
		$I->waitForPageLoad(30); // stepKey: selectAttributeSetStartEditAttrSet2WaitForPageLoad
		$I->comment("Exiting Action Group [startEditAttrSet2] AdminSelectAttributeSetOnEditProductPageActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("save the product/published by default");
		$I->comment("Entering Action Group [clickSaveButton2] AdminProductFormSaveActionGroup");
		$I->click("#save-button"); // stepKey: saveProductClickSaveButton2
		$I->waitForPageLoad(30); // stepKey: saveProductClickSaveButton2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavingClickSaveButton2
		$I->comment("Exiting Action Group [clickSaveButton2] AdminProductFormSaveActionGroup");
		$I->seeElement(".message-success"); // stepKey: messageYouSavedTheProductIsShown2
		$I->comment("Testing that price appears correctly in admin catalog");
		$I->comment("Set filter to product name");
		$I->comment("Entering Action Group [goToCatalogProductPage2] AdminOpenCatalogProductPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: openCatalogProductPageGoToCatalogProductPage2
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadGoToCatalogProductPage2
		$I->comment("Exiting Action Group [goToCatalogProductPage2] AdminOpenCatalogProductPageActionGroup");
		$I->comment("Entering Action Group [filterBundleProductOptionsDownToName2] FilterProductGridByNameActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterBundleProductOptionsDownToName2
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterBundleProductOptionsDownToName2WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterBundleProductOptionsDownToName2
		$I->fillField("input.admin__control-text[name='name']", "BundleProduct" . msq("BundleProduct")); // stepKey: fillProductNameFilterFilterBundleProductOptionsDownToName2
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterBundleProductOptionsDownToName2
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterBundleProductOptionsDownToName2WaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterBundleProductOptionsDownToName2
		$I->comment("Exiting Action Group [filterBundleProductOptionsDownToName2] FilterProductGridByNameActionGroup");
		$I->seeElement("//tr[@data-repeat-index='0']//div[contains(., 'Default')]"); // stepKey: seeAttributeSet2
	}
}
