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
 * @Title("https://github.com/magento/magento2/pull/25132: We should validate the form when the user click Save in New Attribute Set")
 * @Description("Admin should be able to create product attribute and validate the form when the user click Save in New Attribute Set<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminCreateNewAttributeFromProductPageTest.xml<br>")
 * @TestCaseId("https://github.com/magento/magento2/pull/25132")
 * @group Catalog
 */
class AdminCreateNewAttributeFromProductPageTestCest
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
	 * @Features({"Catalog"})
	 * @Stories({"We should validate the form when the user click Save in New Attribute Set"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateNewAttributeFromProductPageTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [goToProductCatalogPage] AdminOpenCatalogProductPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: openCatalogProductPageGoToProductCatalogPage
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadGoToProductCatalogPage
		$I->comment("Exiting Action Group [goToProductCatalogPage] AdminOpenCatalogProductPageActionGroup");
		$I->comment("Entering Action Group [goToCreateProduct] GoToCreateProductPageActionGroup");
		$I->click(".action-toggle.primary.add"); // stepKey: clickAddProductToggleGoToCreateProduct
		$I->waitForPageLoad(30); // stepKey: clickAddProductToggleGoToCreateProductWaitForPageLoad
		$I->waitForElementVisible(".item[data-ui-id='products-list-add-new-product-button-item-simple']", 30); // stepKey: waitForAddProductDropdownGoToCreateProduct
		$I->click(".item[data-ui-id='products-list-add-new-product-button-item-simple']"); // stepKey: clickAddProductTypeGoToCreateProduct
		$I->waitForPageLoad(30); // stepKey: waitForCreateProductPageLoadGoToCreateProduct
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/new/set/4/type/simple/"); // stepKey: seeNewProductUrlGoToCreateProduct
		$I->see("New Product", ".page-header h1.page-title"); // stepKey: seeNewProductTitleGoToCreateProduct
		$I->comment("Exiting Action Group [goToCreateProduct] GoToCreateProductPageActionGroup");
		$I->comment("Entering Action Group [clickAddAttribute] AdminClickAddAttributeOnProductEditPageActionGroup");
		$I->click("#addAttribute"); // stepKey: clickAddAttributeBtnClickAddAttribute
		$I->waitForPageLoad(30); // stepKey: clickAddAttributeBtnClickAddAttributeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSidePanelClickAddAttribute
		$I->see("Select Attribute"); // stepKey: checkNewAttributePopUpAppearedClickAddAttribute
		$I->comment("Exiting Action Group [clickAddAttribute] AdminClickAddAttributeOnProductEditPageActionGroup");
		$I->comment("Entering Action Group [clickCreateNewAttribute1] AdminClickCreateNewAttributeFromProductEditPageActionGroup");
		$I->click("//button[@data-index='add_new_attribute_button']"); // stepKey: clickCreateNewAttributeClickCreateNewAttribute1
		$I->waitForPageLoad(30); // stepKey: clickCreateNewAttributeClickCreateNewAttribute1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSidePanelClickCreateNewAttribute1
		$I->comment("Exiting Action Group [clickCreateNewAttribute1] AdminClickCreateNewAttributeFromProductEditPageActionGroup");
		$I->comment("Entering Action Group [fillAttributeData] AdminFillAttributeDataProductFormNewAttributeActionGroup");
		$I->fillField("//input[@name='frontend_label[0]']", "TestAttributeName"); // stepKey: fillAttributeLabelFillAttributeData
		$I->waitForPageLoad(30); // stepKey: fillAttributeLabelFillAttributeDataWaitForPageLoad
		$I->selectOption("//select[@name='frontend_input']", "Text Field"); // stepKey: selectAttributeTypeFillAttributeData
		$I->waitForPageLoad(30); // stepKey: selectAttributeTypeFillAttributeDataWaitForPageLoad
		$I->comment("Exiting Action Group [fillAttributeData] AdminFillAttributeDataProductFormNewAttributeActionGroup");
		$I->click("button#saveInNewSet"); // stepKey: saveAttributeInSet
		$I->waitForPageLoad(10); // stepKey: saveAttributeInSetWaitForPageLoad
		$I->comment("Entering Action Group [assertPopUp] AdminAssertProductEditPageCreateAttributeSaveInAttributeSetPopUpShownActionGroup");
		$I->see("Enter Name for New Attribute Set"); // stepKey: seeContentAssertPopUp
		$I->comment("Exiting Action Group [assertPopUp] AdminAssertProductEditPageCreateAttributeSaveInAttributeSetPopUpShownActionGroup");
		$I->click("//footer[@class='modal-footer']/button[contains(@class, 'action-dismiss')]"); // stepKey: cancelButton
		$I->comment("Entering Action Group [emptyAttributeData] AdminFillAttributeDataProductFormNewAttributeActionGroup");
		$I->fillField("//input[@name='frontend_label[0]']", " "); // stepKey: fillAttributeLabelEmptyAttributeData
		$I->waitForPageLoad(30); // stepKey: fillAttributeLabelEmptyAttributeDataWaitForPageLoad
		$I->selectOption("//select[@name='frontend_input']", " "); // stepKey: selectAttributeTypeEmptyAttributeData
		$I->waitForPageLoad(30); // stepKey: selectAttributeTypeEmptyAttributeDataWaitForPageLoad
		$I->comment("Exiting Action Group [emptyAttributeData] AdminFillAttributeDataProductFormNewAttributeActionGroup");
		$I->click("button#saveInNewSet"); // stepKey: clickSaveInSet
		$I->waitForPageLoad(10); // stepKey: clickSaveInSetWaitForPageLoad
		$I->see("This is a required field."); // stepKey: seeThisIsRequiredField
		$I->dontSee("Enter Name for New Attribute Set"); // stepKey: dontSeePopUp
	}
}
